<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class StaticFrontpageDispatcher {
  public function __construct() {
    View::render('single-column', 'static-frontpage');
  }
}
