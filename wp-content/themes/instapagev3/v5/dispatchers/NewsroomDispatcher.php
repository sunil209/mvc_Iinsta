<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class NewsroomDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'newsroom');
    }
}
