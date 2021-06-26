<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;

class WebinarDispatcher
{
    public function __construct()
    {
        if (is_single()) {
            $page = getV5Page();
            $model = Factory::getModel($page);
            $contextID = $model->getContextID();
            $contextID = $contextID instanceof \WP_Post ? $contextID->ID : $contextID;
            View::render('single-column', 'single', ['contextID' => $contextID]);
        } else {
            $page = getV5Page();
            $model = Factory::getModel($page);
            $contextID = $model->getContextID();
            $postType = get_post_type();

            View::render('single-column', 'webinars-listing', [
                'contextID' => $contextID,
                'postType' => $postType,
            ]);
        }
    }
}
