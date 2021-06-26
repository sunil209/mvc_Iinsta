<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class PlansDispatcher {
  public function __construct() {
    View::render('single-column', 'plans');
  }
}
