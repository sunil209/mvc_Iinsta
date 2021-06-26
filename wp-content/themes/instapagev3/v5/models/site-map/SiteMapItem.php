<?php
namespace Instapage\Models\SiteMap;

/**
 * Single sitemap item
 */
class SiteMapItem {

  /**
   * @var string Title of the sitemap item. Will be used in the view
   */
  public $title;

  /**
   * @var string Url of the sitemap item. Will be used in the view
   */
  public $url;

  /**
   * Create new site map item
   *
   * @param string $title   Title of site map item. Will be used in the view.
   * @param string $url     Url of site map item. Will be used in the view.
   *
   * @uses self::$title
   * @uses self::$url
   * 
   * @return void
   */
  public function __construct(string $title = '', string $url = '') {
    $this->title = $title;
    $this->url = $url;
  }
}
