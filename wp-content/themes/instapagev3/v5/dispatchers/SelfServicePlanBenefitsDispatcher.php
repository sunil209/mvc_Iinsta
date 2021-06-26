<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class SelfServicePlanBenefitsDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'core-benefits');
    }
}
