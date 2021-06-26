<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class PressKitDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'press-kit');
    }
}
