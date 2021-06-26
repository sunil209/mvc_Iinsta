<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class FullServiceTermsDispatcher {
  public function __construct() {
    View::render('single-column', 'full-service-terms');
  }
}
