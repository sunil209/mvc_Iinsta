<?php
namespace Instapage\Classes\Amp;

use \Instapage\Models\Amp as AmpModel;
use \Instapage\Classes\Templates\ClassTemplates;

/**
 * Encapsulates all methods used to work with AMP pages
 */
class Amp {
  /**
   * @var array Array of AmpContentFilter objects
   */
  protected $contentFilters = [];

  /**
   * @var AmpModel $ampModel We're creating only one instance for model
   */
  protected $ampModel = null;

  /**
   * @const array Holds amp pages configuration, key equals to amp slug, value to post type corresponding to given amp page
   */
  public static $ampPages = [
      'amp' => 'post',
      'guides-amp' => 'seo-page',
      'page-amp' => 'page',
      'marketing-dictionary-amp' => 'dictionary-term',
      'features-amp' => 'feature',
      'customer-stories-amp' => 'customer-stories'
  ];

  /**
   * Get AMP model, so we have only one instance of model in all operations trough this class.
   *
   * @return AmpModel
   */
  public function getAmpModel() {
    if ($this->ampModel === null) {
      return new AmpModel();
    }
    return $this->ampModel;
  }

  /**
   * Method for returning one dimnesional array with registered amp slugs.
   *
   * Example of array looks like: ['firstAmpSlug', 'Second Amp Slug' ...]
   *
   * @return array One dimnesional array with registered amp slug like ['firstAmpSlug', 'Second Amp Slug' ...]
   */
  public static function getAmpSlugs() {
    return array_keys(self::$ampPages);
  }

  /**
   * Method for returning one dimnesnional array with post types with amp enabled
   *
   * Example of array looks like: ['firstPostType', 'secondPostType' ...]
   *
   * @return array One dimnesional array with post types with amp enabled, like: ['firstPostType', 'secondPostType' ...]
   */
  public static function getAmpPostTypes() {
    return array_values(self::$ampPages);
  }

  /**
   * Checks whether AMP logic should be enabled
   * @return bool
   */
  public function isEnabled() {
    return $this->getAmpModel()->isAmpEnabled();
  }

  /**
   * Registers new filter to pass content through. If any filter with the same name existed before - it'll be overwritten.
   * @param  AmpContentFilter $filter
   * @return void
   */
  public function registerFilter(AmpContentFilter $filter) {
    $this->contentFilters[$filter->getName()] = $filter;
  }

  /**
   * Unregisters filter.
   * @param  AmpContentFilter $filter
   * @return void
   */
  public function unregisterFilter(AmpContentFilter $filter) {
    unset($this->contentFilters[$filter->getName()]);
  }

  /**
   * Returns true if there's at least one registered filter
   * @return bool
   */
  public function hasFilters() {
    return !empty($this->contentFilters);
  }

  /**
   * Returns all registered filters
   * @return array
   */
  public function getFilters() {
    return $this->contentFilters;
  }

  /**
   * Filters $input using registered filters and returns new content.
   * @param  string $input Content to be filtered
   * @return string Content with not-allowed tags filtered out
   */
  public function filter($input) {
    if (empty($input) || !$this->hasFilters()) {
      return $input;
    }

    $output = $input;
    foreach ($this->getFilters() as $filter) {
      $callback = $filter->getCallback();
      if (is_callable($callback)) {
        $output = call_user_func($callback, $output);
      }
    }

    return $output;
  }

  /**
   * Try to find post type of content based on amp slug
   * @param  string $slug
   *
   * @return string If it is proper amp slug return matching post type, if no return empty string.
   */
  public function getPostTypeBasedOnAmpSlug($slug) {
    // iterate trough all $ampPages definitions
    foreach (self::$ampPages as $ampSlug => $postType) {
      // check if in the begining of the slug we have correct amp slug
      $ampSlugWithSlashes = '/' . $ampSlug . '/';
      if (substr($slug, 0, strlen($ampSlugWithSlashes)) === $ampSlugWithSlashes) {
        return $postType;
      }
    }

    // it means that given slug is not proper
    return '';
  }

  /**
   * Removes $slugPrefix from $slug. It's used to get canonical slug from amp slug
   * @param  string $slug
   * @return string
   */
  public function stripAmpSlug($slug) {
    // getting defined ampSlugs, amp slugs are kept in keys of array,
    // so using proper function
    $ampSlugs = self::getAmpSlugs();
    // and we need to add slashes at the end and begining of ampSlug
    $ampSlugsWithSlashes = array_map(function ($ampSlug) {
      return '/' . $ampSlug . '/';
    }, $ampSlugs);

    return str_replace($ampSlugsWithSlashes, '', $slug);
  }

  /**
   * Check if blue amp on/off toggle in wp-admin post edit screen is enabled.
   *
   * This ACF on/off toggle is responsible for turning off single posts amp versions,
   * so we need to know his state for given post
   *
   * @param  \WP_Post $post post object
   *
   * @return bool Return true if toggle is on, otherwise false.
   */
  public function checkIfAmpToggleIsEnabled(\WP_Post $post) {
    $hasPostEnabledAMP = intval(get_post_meta($post->ID, 'enable_amp', $single = true)) === 1;

    // if post has not enabled AMP maybe his intro post has? Check that
    if (!$hasPostEnabledAMP) {
      $hasPostEnabledAMP = $this->getAmpModel()
                            ->checkIfAmpToggleIsEnabledForChapters($post);
    }

    return $hasPostEnabledAMP;
  }

  /**
   * Returns url to amp version of currently requested content.
   *
   * It is very useful to get url for rel='amphtml'. Link will be returned only if
   * requested post has blue amp toggle set to on.
   *
   * @uses   \Instapage\Classes\Amp\Amp::checkIfAmpToggleIsEnabled()
   * @return string Url to AMP version or empty string
   */
  public function getAmpUrl() {
    // single landing page template is not regular post,
    // it is adhoc generated content from the API, so it is treated in another way
    $classTemplateAmpUrl = ClassTemplates::getAmpUrl();
    if (!empty($classTemplateAmpUrl)) {
      return $classTemplateAmpUrl;
    }

    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $newUrl = '';
    $requestedPost = get_post();

    // if switch is off, there is no amp version of requested post, so return empty string
    if (!$requestedPost || !$this->checkIfAmpToggleIsEnabled($requestedPost)) {
      return '';
    }

    // on 404 page we do not want to generate amp URL
    if (is_404()) {
      return '';
    }

    switch ($requestedPost->post_type) {
      case 'post':
        // For now we have only amp version for single blog posts
        if (is_single()) {
          $newUrl = str_replace('/blog/', '/amp/', $url);
        }
        break;
      case 'dictionary-term':
        // For now we have only amp version for single dictionary-term
        if (is_single()) {
          $newUrl = str_replace('/marketing-dictionary/', '/marketing-dictionary-amp/', $url);
        }
        break;
      case 'feature':
        if (is_single()) {
          $newUrl = str_replace('/features/', '/features-amp/', $url);
        }
        break;
      case 'customer-stories':
        if (is_single()) {
          $newUrl = str_replace('/customer-stories/', '/customer-stories-amp/', $url);
        }
        break;
      case 'page':
        $newUrl = '/page-amp' . str_replace('/page-amp/', '/', $url);
        break;
      case 'seo-page':
        // for now, we have only amp for single guides
        if (is_single()) {
          // guides singe post has no slug /guides/ it is just instapage.com/post-name
          $newUrl = '/guides-amp' . str_replace('/guides-amp/', '/', $url);
        }
        break;
      default:
        $newUrl = '';
    }

    return $newUrl;
  }

  /**
   * Method check if set metatag amp as enabled
   *
   * If given blog or author page always return false
   * If given single template then always return true
   * Check if blue amp on/off toggle in wp-admin post edit screen is enabled
   *
   * @return bool Return true if page has enabled amp, otherwise false.
   */
  public function hasPageEnabledAmp() : bool {
    global $post;

    //if listing categories then set metatag ampenabled as false
    if (is_category()) {
      return false;
    }

    //if page is blog set metatag ampenabled as false
    if (!is_front_page() && is_home()) {
      return false;
    }

    //if author page set metatag ampenabled as false
    if (is_author()) {
      return false;
    }

    $classTemplates = new ClassTemplates();
    $ampEnabled = $classTemplates->isSingleTemplateUrl();

    if (!empty($post)) {
      $ampEnabled = $ampEnabled || $this->checkIfAmpToggleIsEnabled($post);
    }

    return $ampEnabled;
  }
}
