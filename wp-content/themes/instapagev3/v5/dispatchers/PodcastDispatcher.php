<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;

class PodcastDispatcher
{
    public function __construct()
    {
        if (is_single()) {
            View::render('dual-column', 'podcast-single');
        } else {
            $page = getV5Page();
            $model = Factory::getModel($page);
            $contextID = $model->getContextID();
            $contextID = $contextID instanceof \WP_Post ? $contextID->ID : $contextID;
            View::render(
                'single-column',
                'podcast-listing',
                [
                    'contextID' => $contextID,
                    'postType' => get_post_type()
                ]
            );
        }
    }
}
