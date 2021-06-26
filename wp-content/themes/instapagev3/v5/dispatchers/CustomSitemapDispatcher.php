<?php
namespace Instapage\Dispatchers;

use \Instapage\Classes\View;
use \Instapage\Classes\CustomSitemap\CustomSitemap;

class CustomSitemapDispatcher {
  public function __construct() {
    if (!headers_sent()) {
      header('HTTP/1.1 200 OK');
      header('Content-Type: text/xml');
    }

    View::render(
      'single-column',
      'custom-sitemap',
      [
        'data' => CustomSitemap::getInstance()->getData(
          parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        )
      ]
    );
  }
}
