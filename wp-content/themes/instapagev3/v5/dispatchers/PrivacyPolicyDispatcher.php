<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class PrivacyPolicyDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'agreement-page');
    }
}
