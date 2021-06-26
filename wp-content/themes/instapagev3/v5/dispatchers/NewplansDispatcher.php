<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class NewplansDispatcher {
  public function __construct() {
    View::render('single-column', 'newplans');
  }
}
