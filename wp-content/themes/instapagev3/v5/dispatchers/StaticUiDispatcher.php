<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class StaticUiDispatcher {
  public function __construct() {
    View::render('single-column', 'static-ui');
  }
}
