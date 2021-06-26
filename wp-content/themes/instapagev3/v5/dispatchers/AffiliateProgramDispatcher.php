<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class AffiliateProgramDispatcher {
  public function __construct() {
    View::render('single-column', 'affiliate-program');
  }
}
