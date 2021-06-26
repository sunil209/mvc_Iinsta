<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class ContactDispatcher {
  public function __construct() {
    View::render('single-column', 'contact');
  }
}
