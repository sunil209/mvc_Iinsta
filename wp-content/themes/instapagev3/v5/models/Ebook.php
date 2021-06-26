<?php
namespace Instapage\Models;

/**
 * Model for /ebooks page
 */
class Ebook {
  /**
   * @var string $postType Holds information about what postType should be used with this model
   */
  public $postType = 'ebook';

  /**
   * Returns ID of page from which ACF fields for header section should be taken from
   * @return int
   */
  public function getContextID() {
    return get_page_by_path('static-ebook');
  }
}
