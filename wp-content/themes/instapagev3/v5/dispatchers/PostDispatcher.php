<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;

class PostDispatcher
{
    public function __construct()
    {
        if (is_single()) {
            if (isAmp()) {
                View::render('amp', 'single');
            } else {
                $page = getV5Page();
                $model = Factory::getModel($page);
                $contextID = $model->getContextID();
                $contextID = $contextID instanceof \WP_Post ? $contextID->ID : $contextID;
                View::render('single-column', 'single', ['contextID' => $contextID]);
            }
        } else {
            $page = getV5Page();
            $model = Factory::getModel($page);
            $contextID = $model->getContextID();
            $contextID = $contextID instanceof \WP_Post ? $contextID->ID : $contextID;
            View::render('single-column', 'blog-listing', ['contextID' => $contextID, 'postType' => get_post_type()]);
        }
    }
}
