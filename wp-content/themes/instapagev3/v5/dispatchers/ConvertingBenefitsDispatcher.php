<?php
namespace Instapage\Dispatchers;
use Instapage\Classes\View;
class ConvertingBenefitsDispatcher {
  public function __construct() {
    View::render('single-column', 'enterprise-benefits');
  }
}
