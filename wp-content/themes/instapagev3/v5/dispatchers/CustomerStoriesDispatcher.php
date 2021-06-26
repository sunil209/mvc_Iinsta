<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;

class CustomerStoriesDispatcher
{
    public function __construct()
    {
        if (is_single()) {
            if (isAmp()) {
                View::render('amp', 'case-study');
            } else {
                View::render('single-column', 'case-study-single');
            }
        } else {
            $model = Factory::getModel(getV5Page());
            $contextID = $model->getContextID();
            $contextID = $contextID instanceof \WP_Post ? $contextID->ID : $contextID;
            View::render('single-column', 'customer-stories-listing', ['contextID' => $contextID]);
        }
    }
}
