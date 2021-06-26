<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class EnterpriseThankYouDispatcher {
  public function __construct() {
    View::render('single-column', 'enterprise-thank-you');
  }
}
