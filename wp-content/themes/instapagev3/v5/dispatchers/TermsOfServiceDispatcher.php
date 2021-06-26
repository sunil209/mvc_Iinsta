<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class TermsOfServiceDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'agreement-page');
    }
}
