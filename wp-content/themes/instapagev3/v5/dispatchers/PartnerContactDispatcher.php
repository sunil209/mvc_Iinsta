<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class PartnerContactDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'partner-contact');
    }
}
