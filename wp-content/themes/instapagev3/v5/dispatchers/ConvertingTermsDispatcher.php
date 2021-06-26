<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class ConvertingTermsDispatcher {
  public function __construct() {
    View::render('single-column', 'enterprise-terms');
  }
}
