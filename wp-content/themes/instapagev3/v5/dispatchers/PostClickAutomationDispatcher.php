<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class PostClickAutomationDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'post-click-automation');
    }
}
