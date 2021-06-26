<?php
namespace Instapage\Classes\AbTesting;

use \Instapage\Classes\AbTesting\Variation;
use \Instapage\Classes\Data;
use \Instapage\Helpers\PreWpHelper;

/**
 * Class that controls server-side A/B tests. Each Experiment object must have an array of variations.
 *
 * Caution! Class is used before initialization of WP, so using WP functions is prohibited here! Use \Instapage\Helpers\PreWpHelper instead.
 */
class Experiment {

  /**
   * @var string $id Google Optimize experiment ID
   */
  public $id = null;

  /**
   * @var array $variation List of variations for the experiment.
   */
  private $variations = [];

  /**
   * @var Variation $currentVariation A variation selected randomly when request is handeled.
   */
  private $currentVariation = null;

  /**
   * @var string $originalPath Original path for the experiment.
   */
  private $originalPath = null;

  /**
   * @var string $currentPath Current path from $_SERVER['REQUEST_URI'].
   */
  private $currentPath = null;

  /**
   * @var string $currentQuery Current query from $_SERVER['REQUEST_URI'].
   */
  private $currentQuery = null;

  /**
   * @var int $duration Experiment duration in days.
   */
  private $duration = null;

  /**
   * @var date $startDate Experiment start date.
   */
  private $startDate = null;

   /**
   * @var string $googleOptimizesScript JavaScript code that needs to be added at the end of HTML document
   */
  private $googleOptimizeScript = null;

  /**
   * Constructor. Variations in a list should have summary traffic split ratio less of equal to 1.
   *
   * @param string $id Google Optimize ID of the experiment.
   * @param string $originalPath Original path for the experiment.
   * @param array $variations List of variations. All elements should have \Instapage\Classes\AbTesting\Variation class. Sum of traffic split ratios in all variations can't be larger than 1.
   * @param \DateTime $startDate Start date of the experiment.
   * @param int $duration Experiment duration in days. Default: 30.
   *
   * @throws Exception When the element of $variations array has incorrect type and if summary traffic split ratio of all variations is greater than 1.
   *
   * @return void
   */
  public function __construct(string $id, string $originalPath, array $variations, \DateTime $startDate, int $duration = 30) {

    $this->id           = $id;
    $this->originalPath = $originalPath;
    $currentUri         = Data::_server('REQUEST_URI', '/');
    $this->currentPath  = parse_url($currentUri, PHP_URL_PATH);
    $this->currentQuery = parse_url($currentUri, PHP_URL_QUERY);
    $this->startDate    = $startDate;
    $this->duration     = (int) $duration;

    $ratio = 0;
    foreach ($variations as $v) {
      if (!$v instanceof Variation) {
        throw new \Exception('All variations should be instances if \Instapage\Classes\AbTesting\Variation');
      }
      $ratio += $v->trafficSplitRatio;
      $this->variations[$v->id] = $v;

      if ($v->redirectPath === $this->currentPath) {
        $this->currentVariation = $v;
      }
    }

    if ($ratio > 1) {
      throw new \Exception('Sum of traffic split ratios in all variations should be less 1');
    }

    $this->execute();
    $this->setGoogleOptimizeScript();
  }

  /**
   * Returns a variation, selected randomly or null, if the Original is selected.
   * @return \Instapage\Classes\AbTesting\Variation | null
   */
  public function getRandomVariation() {
    $random = lcg_value();
    $ratio  = 0;

    foreach ($this->variations as $v) {
      $ratio += $v->trafficSplitRatio;
      if ($ratio >= $random) {
        return $v;
      }
    }

    return null;
  }

  /**
   * Returns a cookie value of the experiment, if a variation for a user is already picked and stored in a cookie. Returns false if there is no cookie yet.
   *
   * @return string | false
   */
  private function getExperimentalCookieValue() {
    return Data::_cookie($this->getExperimentCookieName(), false);
  }

  /**
   * Returns full experimental cookie name.
   *
   * @return string
   */
  private function getExperimentCookieName() {
    return 'ipe_' . $this->id;
  }

  /**
   * Sets a cookie for experiment, to serve the same variation for a user, if a variation was already picked for him.
   *
   * @param string $value Value of the experimental cookie.
   *
   * @uses setcookie()
   *
   * @return bool If setcookie() successfully runs, it will return TRUE. This does not indicate whether the user accepted the cookie.
   */
  private function setExperimentCookie($value) {
    return setcookie($this->getExperimentCookieName(), $value, time() + 60 * 60 * 24 * (int) $this->duration, '/', parse_url(PreWpHelper::getSiteUrl(), PHP_URL_HOST));
  }

  /**
   * Gets the redirect path of selected variation, or original path if no variation was selected.
   *
   * @return string Redirect path.
   */
  private function getRedirectPath() {
    if (($variationId = $this->getExperimentalCookieValue()) !== false) {
      return $this->variations[$variationId]->redirectPath ?? $this->originalPath;
    }
    $variation    = $this->getRandomVariation();
    $cookieValue  = $variation->id ?? 0;
    $redirectPath = $variation->redirectPath ?? $this->originalPath;
    $this->setExperimentCookie($cookieValue);

    return $redirectPath;
  }

  /**
   * Gets redirect URL, based on randomly picked variation.
   *
   * @param ?string $path Redirect path. By default if will get the value from getRedirectPath()
   *
   * @uses \Instapage\Classes\AbTesting\Experiment::getRedirectPath()
   *
   * @return string Redirect URL.
   */
  private function getRedirectUrl(?string $path = null) {
    $redirectPath = $path ?? $this->getRedirectPath();
    return PreWpHelper::getSiteUrl() . $redirectPath . ($this->currentQuery ? '?' . $this->currentQuery : '');
  }

  /**
   * Checks if all experiment conditions are met.
   *
   * @return bool
   */
  private function checkExperimentCondition() {
    return (
      $this->isOriginalPathMatchesRequest()
      && $this->isRedirectPossible()
      && new \DateTime() <= (clone $this->startDate)->add(new \DateInterval('P' . $this->duration . 'D'))
    );
  }

  /**
   * Checks if the redirect should happen.
   *
   * @return bool
   */
  private function isOriginalPathMatchesRequest() : bool {
    return $this->currentPath === $this->originalPath;
  }

  /**
   * Functions checks if the params from URL query match Defender Pro plugin pattern
   * @param array $queryArray An array of URL query params
   *
   * @return bool
   */
  private function isDefenderRequest(array $queryArray) {
    foreach ($queryArray as $paramName => $paramValue) {
      if (strpos($paramName, 'defender') !== false) {
        return true;
      }
    }
    return false;
  }

  /**
   * Checks if the request is possible. We can't redirect responses to search forms, post previews.
   *
   * @return bool
   */
  private function isRedirectPossible() : bool {
    parse_str($this->currentQuery, $queryArray);
    return
      //not a search request
      !isset($queryArray['s'])
      //not a post preview request
      && !isset($queryArray['preview'])
      // not a Defender Pro plugin request
      && !$this->isDefenderRequest($queryArray);
  }

  /**
   * Performs the redirect, if experiment conditions are met and redirect is needed.
   *
   * @return void
   */
  public function execute() {
    if ($this->checkExperimentCondition()) {
      $redirectPath = $this->getRedirectPath();
      if ($this->isOriginalPathMatchesRequest()) {
        $this->disableGoogleCdnCache();
      }
      if ($this->currentPath !== $redirectPath) {
        PreWpHelper::redirect($this->prepareRedirectPath($redirectPath));
        exit;
      }
    }
  }

  /**
   * Returns path to proper variant with GET parameters (it is useful for marketing purposes, like utm_*)
   */
  private function prepareRedirectPath(string $redirectPath): string {
    $queryString = Data::_server('QUERY_STRING', '', FILTER_SANITIZE_URL);

    if (!empty($queryString)) {
      return $redirectPath . '?' . $queryString;
    }
    return $redirectPath;
  }

  /**
   * Calculates necessary JS scripts to send the data to Google Optimize.
   *
   * @return void
   */
  private function setGoogleOptimizeScript() {
    if (!$this->isOriginalPathMatchesRequest() && !$this->currentVariation) {
      return;
    }

    $variationId = $this->currentVariation->id ?? 0;
    $this->googleOptimizeScript = "
    <script>
    document.addEventListener('discovery:google-analytics', function pingGoogleOptimizeExperiment() {
      if(ga) {
        ga('set', 'exp', '$this->id.$variationId');
        ga('send', 'pageview');
      } else {
        console.error('no ga loaded');
      }
    }, false);
    </script>
    ";
  }

  /**
   * Adds a necessary JS script at the end of HTML document.
   *
   * @param string $html HTML to alter. Script will be added at the end.
   */
  public function applyGoogleOptimizeScript(&$html) {
    $endHtmlTag = '</body>';
    if (isset($this->googleOptimizeScript) && ! empty($this->googleOptimizeScript)) {
      $html = str_replace($endHtmlTag, $this->googleOptimizeScript . $endHtmlTag, $html);
    }
  }

  /**
   * Disables Google CDN caching of the request by modifying response headers.
   */
  function disableGoogleCdnCache() {
    if (!headers_sent()) {
      header('Expires: Wed, 11 Jan 1984 05:00:00 GMT');
      header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
    }

    /*
    Header settings might be overriten by WP or .htaccess rules. That's why we are setting the cookie in response.
    Setting a response cookie also prevents Google CDN from caching the response.
    */
    setcookie('no-cache', 'true');
  }
}
