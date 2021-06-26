<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class RetargetingSolutionsDispatcher {
  public function __construct() {
    View::render('single-column', 'retargeting-solutions');
  }
}
