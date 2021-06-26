<?php
namespace Instapage\Models;

/**
 * Model for /videos page
 */
class Video {
  /**
   * @var string $postType Holds information about what postType should be used with this model
   */
  public $postType = 'video';

  /**
   * Returns ID of page from which ACF fields for header section should be taken from
   * @return int
   */
  public function getContextID() {
    return get_page_by_path('static-video');
  }
}
