<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class Error404Dispatcher {
  public function __construct() {
    View::render('single-column', '404');
  }
}
