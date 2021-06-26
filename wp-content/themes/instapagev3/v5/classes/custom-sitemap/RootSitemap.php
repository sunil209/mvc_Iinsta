<?php
namespace Instapage\Classes\CustomSitemap;

/**
 * Abstract class defining custom sitemap
 */
abstract class RootSitemap {
  /**
   * @var bool $isEnabled Decides whether use this sitemap or ignore it
   */
  public $isEnabled = true;

  /**
   * @var string $path Holds path under which current sitemap can be accessed
   */
  public $path = 'custom-sitemap.xml';

  /**
   * Returns an array of links for sitemap file
   * @return array
   */
  abstract public function getData();
}
