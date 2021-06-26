<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class AdwordsEbook2Dispatcher {
  public function __construct() {
    if (isAmp()) {
      View::render('amp', 'adwords-ebook-2');
    } else {
      // View::render('single-column', 'adwords-ebook-2');
      View::render('single-column', '404');
    }
  }
}
