<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

/**
 * Dispatcher for HTML SiteMap, one dispatcher will be used for listing of all sitemaps and sitemaps itself.
 */
class SiteMapDispatcher {
  public function __construct() {
    View::render('single-column', 'site-map-html');
  }
}
