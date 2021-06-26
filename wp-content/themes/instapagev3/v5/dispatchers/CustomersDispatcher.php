<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;

class CustomersDispatcher
{
    public function __construct()
    {
        View::render('single-column', 'customers', ['topMenu' => getV5Menu('v5-top-menu')]);
    }
}
