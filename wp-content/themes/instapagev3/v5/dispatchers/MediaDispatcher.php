<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class MediaDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'media');
    }
}
