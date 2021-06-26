<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class PartnersDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'partners');
    }
}
