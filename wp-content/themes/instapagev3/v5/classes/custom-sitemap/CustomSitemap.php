<?php
namespace Instapage\Classes\CustomSitemap;

/**
 * Allows to use custom sitemap along with others already provided by SEO plugin
 */
class CustomSitemap {
  use \Instapage\Traits\Singleton;

  /**
   * @var array $handlers Array of handlers against which all sitemap requests will be checked
   */
  protected $handlers = [];

  /**
   * Registers itself in SEO plugin sitemap index
   * @param  Sitemap $handler
   * @uses   self::$handlers
   * @return void
   */
  public function register(RootSitemap $handler) {
    if ($handler->isEnabled && !empty($handler->path)) {
      $this->handlers[] = $handler;

      add_filter(
        'wpseo_sitemap_index',
        function($sitemap) use ($handler) {
          $xml = sprintf(
            '<sitemap>
              <loc>%1$s</loc>
              <lastmod>%2$s</lastmod>
            </sitemap>',
            'https://' . $_SERVER['DESIRED_DOMAIN'] . '/' . $handler->path,
            date(\DateTime::W3C)
          );
          return $sitemap . $xml;
        },
        10,
        1
      );
    }
  }

  /**
   * Returns true is given url should be handled by registered sitemap
   * @param  string $url Request url
   * @uses   self::$handlers
   * @return bool
   */
  public function isSitemap($url) {
    foreach ($this->handlers as $handler) {
      if ($handler->isEnabled && (ltrim($url, '/') === $handler->path)) {
        return true;
      }
    }

    return false;
  }

  /**
   * Returns an array of links for sitemap file
   * @return array
   */
  public function getData($url) {
    foreach ($this->handlers as $handler) {
      if ($handler->isEnabled && (ltrim($url, '/') === $handler->path)) {
        return $handler->getData();
      }
    }
  }
}
