<?php
namespace Instapage\Classes\Templates;

use Instapage\Classes\Factory;
/**
 * Class used for /landing-page-templates and /landing-page-templates/* pages
 */
class ClassTemplates {
  use \Instapage\Traits\Singleton;
  use \Instapage\Traits\ExternalJSON;

  /**
   * @var array $categories Holds available categories
   */
  private $categories = [];

  /**
   * @var array $templates Holds available templates
   */
  private $templates = [];
  
  const slug = 'landing-page-templates';
  const ampSlug = 'landing-page-templates-amp';
  
  /**
   * @var string Pattern used for single page url matching
   */
  private static $singlePagePattern = '#landing\-page\-templates\/(?<Slug>[a-z0-9\_\-]+)$#i';

  /**
   * @var string Pattern used for single amp page url matching
   */
  private static $singlePagePatternAmp = '#landing\-page\-templates\-amp\/(?<Slug>[a-z0-9\_\-]+)$#i';

  /**
   * @var string containing current template slug
   */
  private static $currentTemplateSlug = null;
  /**
   * @var string API_ENDPOINT Url of API endpoint from which template data are fetched
   */
  const API_ENDPOINT = 'https://app.instapage.com/api/2/templates';

  /**
   * @var string CACHE_KEY Key used to persist json data
   */
  const CACHE_KEY = 'template_json';

  /**
   * A constructor. Fetches remote json file upon object creation
   * @uses self::CACHE_KEY
   * @uses self::API_ENDPOINT
   * @uses self::fetchJson()
   * @uses self::fetch()
   * @uses \Instapage\Classes\Factory::getCache()
   */
  public function __construct() {
    $cache = \Instapage\Classes\Factory::getCache();

    try {
      $json = $cache::get(self::CACHE_KEY);

      if ($json === false) {
        $json = self::fetchJson(self::API_ENDPOINT);
        $cache::set(self::CACHE_KEY, $json);
      }

      $this->fetch($json, 'categories');
      $this->fetch($json, 'templates');

      if ($this->isSingleTemplateUrl()) {
        add_action('wpseo_canonical', [Factory::getModel('landing-page-templates'), 'setCanonical']);
      }
    }
    catch (\Exception $e) {
      error_log($e->getMessage());
    }
  }

  /**
   * Checks whether current url should be parsed by Templates class as single page
   * @param  bool $checkPattern Does single template URL pattern should be checked? Default: true
   * @uses   self::isSingleTemplatePatternMatched()
   * @uses   self::getCurrentTemplateSlug()
   * @uses   self::getTemplates()
   * @return bool
   */
  public function isSingleTemplateUrl($checkPattern = true) {
    if ($checkPattern && !self::isSingleTemplatePatternMatched()) {
      return false;
    }

    $currentSlug = self::getCurrentTemplateSlug();
    $templates = $this->getTemplates();

    foreach ($templates as $template) {
      if ($template->slug === $currentSlug) {
        return true;
      }
    }

    return false;
  }
  
  /**
   * Check if given url matches amp single template url pattern
   * 
   * @return boolean
   */
  public static function isAMPversion() {
    $matches = [];
    preg_match_all(self::$singlePagePatternAmp, parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $matches);
    return !empty($matches['Slug'][0]);
  }
  
  /**
   * Switch parts of requested url on condition.
   * 
   * @param string $replace
   * @param string $replaceBy
   * @param bolean $conditionToReplace
   * @return string Result url
   */
  public static function switchSlugsInUrl($replace, $replaceBy, $conditionToReplace) {
    $requestURL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($conditionToReplace) {
      $requestURL = str_replace($replace, $replaceBy, $requestURL);
    }
    return \get_home_url() . $requestURL;
  }
  
  /**
   * Get AMP URL for requested template
   * 
   * URL will be returned only if requested url is landing-page-template, 
   * otherwise empty string.
   * 
   * @return string $ampUrl Url to amp version of content, if requested URL is proper url for class template
   */
  public static function getAmpUrl() {
    $isSingleTemplate = self::getInstance()->isSingleTemplateUrl();
    $ampUrl = '';
    if ($isSingleTemplate) {
      $ampUrl = self::switchSlugsInUrl(self::slug,self::ampSlug,$isSingleTemplate);
    }
    return $ampUrl;
  }
  
  /**
   * Get canonical url
   * 
   * @return string
   */
  public static function getCanonicalUrl() {
    return self::switchSlugsInUrl(self::ampSlug,self::slug,self::isAMPversion());
  }

  /**
   * Gets template slug of current url
   * @uses   self::$singlePagePattern
   * @return string Slug of current template
   */
  public static function getCurrentTemplateSlug() {
    if (self::$currentTemplateSlug !== null) {
      return self::$currentTemplateSlug;
    }

    $matches = [];
    preg_match_all(self::$singlePagePattern, parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $matches);
    if (empty($matches['Slug'][0])) {
      preg_match_all(self::$singlePagePatternAmp, parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $matches);
    }

    self::$currentTemplateSlug = $matches['Slug'][0] ?? '';
    return  self::$currentTemplateSlug;
  }

  /**
   * Checks whether current url should be parsed by Templates class as single page
   * @uses   self::getCurrentTemplateSlug()
   * @return bool
   */
  public static function isSingleTemplatePatternMatched() {
    $slug = self::getCurrentTemplateSlug();
    return !empty($slug);
  }

  /**
   * Fills given $type array with data from $json object
   * @param  string $json JSON file returned from api endpoint
   * @param  string $type Either 'categories' or 'templates'
   * @uses   self::$categories
   * @uses   self::$templates
   * @return void
   */
  private function fetch($json, $type) {
    if (
        (isset($type)) && (!empty($type)) &&
        (in_array($type, ['categories', 'templates'])) &&
        (isset($json->data)) && (!empty($json->data)) &&
        (isset($json->data->$type)) && (!empty($json->data->$type))
    ) {
      $this->$type = $json->data->$type;
    }
  }

  /**
   * Returns closest neighbour that meets the requirements for detailed view.
   * @param  int $currentIndex Index of an element to find a neighbour for.
   * @param  array $templates An array of templates.
   * @param  string $direction Direction of search - 'next' or 'prev'.
   * @uses   self::isDetailedViewReady()
   * @return array|null An array containing single template or null, if no results found.
   */
  private function getNeighbourTemplate($currentIndex, $templates, $direction = 'prev') {
    $c = count($templates);
    $tries = 0;

    while ($tries < $c - 1) {
      $tries++;

      if ($direction === 'prev') {
        $newIndex = ($currentIndex === 0) ? $c - 1 : $currentIndex - 1;
      } else {
        $newIndex = ($currentIndex === $c - 1) ? 0 : $currentIndex + 1;
      }

      if (
        isset($templates[$newIndex]) &&
        !empty($templates[$newIndex]) &&
        $this->isDetailedViewReady($templates[$newIndex])
      ) {
        return $templates[$newIndex];
      }
    }

    return null;
  }

  /**
   * Returns categories array
   * @uses   self::$categories
   * @return array An array containing categories
   */
  public function getCategories() {
    return $this->categories;
  }

  /**
   * Returns templates array. Does not return categories which aren't asigned to any category
   * @uses   self::$templates
   * @return array An array containing templates
   */
  public function getTemplates() {
    $templates = [];

    foreach ($this->templates as $template) {
      if ($template->category !== 0) {
        $templates[] = $template;
      }
    }

    return $templates;
  }

  /**
   * Returns an array containing single template informations
   * @param  string $slug of template to be returned
   * @param  bool $withNeighbours Wether to fetch prev/next templates
   * @param  int $imageIndex to assaign random header background
   * @uses   self::getTemplates()
   * @uses   self::getNeighbourTemplate()
   * @return array An array containing single template
   */
  public function getTemplate($slug, $withNeighbours = false) {
    $templates = $this->getTemplates();

    for ($i = 0, $c = count($templates); $i < $c; $i++) {
      $template = $templates[$i];
      $template->imageIndex = $i % 5;

      if ($template->slug === $slug) {
        if ($withNeighbours) {
          $template->previous = $this->getNeighbourTemplate($i, $templates, 'prev');
          $template->next = $this->getNeighbourTemplate($i, $templates, 'next');
        }

        return $template;
      }
    }

    return null;
  }

  /**
   * Checks if template of given slug actually exists
   * @uses   self::getCurrentTemplateSlug()
   * @uses   self::getTemplate()
   * @return bool
   */
  public function isPresent($slug = '') {
    if (!$slug) {
      $slug = self::getCurrentTemplateSlug();
    }

    return ($this->getTemplate($slug) !== null);
  }

  /**
   * Checks if a template has all the necessary data to have a detailed view.
   * @param  object $template
   * @uses   self::isListingViewReady()
   * @return bool
   */
  public function isDetailedViewReady($template) {
    if (
      $this->isListingViewReady($template) &&
      isset($template->name) && !empty($template->name) &&
      isset($template->slug) && !empty($template->slug) &&
      isset($template->desktop_image) && !empty($template->desktop_image)
    ) {
      return true;
    }

    return false;
  }

  /**
   * Checks if a template has all the necessary data to be shown in listing view.
   * @param  object $template
   * @return bool
   */
  public function isListingViewReady($template) {
    if (isset($template->website_image) && !empty($template->website_image)) {
      return true;
    }

    return false;
  }
}
