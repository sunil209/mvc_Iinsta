<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

/**
 * /homepage for testing
 */
class StartDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'start');
    }
}
