<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class UiKitDispatcher {
  public function __construct() {
    View::render('single-column', 'ui-kit');
  }
}
