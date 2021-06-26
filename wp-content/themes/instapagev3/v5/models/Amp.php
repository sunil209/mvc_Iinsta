<?php
namespace Instapage\Models;

use \Instapage\Classes\Amp\Amp as AmpMain;
use \Instapage\Classes\Templates\ClassTemplates;

/**
 * Model for AMP
 */
class Amp extends Root {
  
  public function isAmpEnabledForSingleTemplate() {
    return ClassTemplates::isAMPversion();
  }
  
  /**
   * Check if AMP toggle is enabled for chapter pages.
   * 
   * For chapter pages we enable amp in intro pages only, so we have to
   * find intro page and check toggle for that.
   * 
   * @param  \WP_Post $post post object
   * 
   * @return bool Return true if toggle is on, otherwise false.
   */
  public function checkIfAmpToggleIsEnabledForChapters(\WP_Post $post) {
    $model = new SeoPage();
    $slug = $model->getPostIntroChapterLink($post);

    $thePost = get_posts([
      'name' => $slug,
      'post_status' => 'publish',
      'post_type' => ['seo-page'],
      'numberposts' => 1,
      'meta_key' => 'enable_amp',
      'meta_compare' => '=',
      'meta_value' => '1'
    ]);
    
    // if there is a post with given parameters it means
    // that AMP is enabled for intro post
    // and it means that AMP is enabled for chapters also
    return !empty($thePost);
  }
  
  /**
   * Checks whether AMP should be enabled for current slug
   * What is more important it returnes true only on AMP version of content. 
   * For example it won't return true for blog post which has 
   * amp but we are on his canonical version.
   * 
   * @return bool
   */
  public function isAmpEnabledForRegularPost() {
    /* @var $amp \Instapage\Classes\Amp\Amp */
    global $amp;
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $slug = end(explode('/', $path));
    // try to determin post type based on amp slug,
    // we have for each post type seperate amp slug
    // so it is possible to know it only based on slug
    $postType = $amp->getPostTypeBasedOnAmpSlug($path);
    
    // if $postType is empty it means that given slug is not correct amp
    if ($postType === '') {
      return false;
    }

    $thePost = get_posts([
      'name' => $slug,
      'post_status' => 'publish',
      // we ask only for on post type 
      // not for an array of posts as it was before
      // by this way we avoid slug collisions among diffrent post types
      // and we are sure that $thePost will contain only on post
      'post_type' => $postType,
      'numberposts' => 1
    ]);
    if (!empty($thePost)) {
      $thePost = $thePost[0];
      if (get_post_type($thePost) === 'seo-page') {
        $ampEnabled = $this->checkIfAmpToggleIsEnabledForChapters($thePost);
        return (!is_404() && $ampEnabled);
      } else {
        return (
          !is_404() 
          && !empty($thePost) 
          && get_post_meta($thePost->ID, 'enable_amp', $single = true) == 1
        );
      }
    }
    return false;
  }
  /**
   * Checks whether AMP should be enabled for current slug
   * What is more important it returnes true only on AMP version of content. 
   * For example it won't return true for blog post which has 
   * amp but we are on his canonical version.
   * 
   * @return bool
   */
  public function isAmpEnabled() {
    return $this->isAmpEnabledForRegularPost()
           || $this->isAmpEnabledForSingleTemplate();
  }

  /**
   * Returns post type for post with given slug or empty string otherwise
   * @param  string $slug Slug to check post type for
   * @return string
   */
  function getPostTypeBySlug($slug) {
    if (empty($slug)) {
      return '';
    }
    
    $thePost = get_posts([
      'name' => $slug,
      'post_status' => 'publish',
      'post_type' => AmpMain::getAmpPostTypes(),
      'numberposts' => 1
    ]);
    return (isset($thePost) && !empty($thePost)) ? get_post_type($thePost[0]) : '';
  }
}
