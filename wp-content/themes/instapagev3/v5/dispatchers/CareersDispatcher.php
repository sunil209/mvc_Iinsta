<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class CareersDispatcher {
  public function __construct() {
    View::render('single-column', 'careers');
  }
}
