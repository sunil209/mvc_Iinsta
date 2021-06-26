<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class AboutDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'about', ['topMenu' => getV5Menu('v5-top-menu')]);
    }
}
