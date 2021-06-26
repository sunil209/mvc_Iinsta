<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\NoTemplateException;

class SolutionDispatcher
{
    public function __construct()
    {
        try {
            global $post;
            View::render('single-column', 'solution-' . $post->post_name);
        } catch (NoTemplateException $e) {
            View::render('single-column', 'solution');
        }
    }
}
