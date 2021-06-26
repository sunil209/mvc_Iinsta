<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;

class EbookDispatcher
{
    public function __construct()
    {
        $page = getV5Page();
        $model = Factory::getModel($page);
        $contextID = $model->getContextID();
        $contextID = $contextID instanceof \WP_Post ? $contextID->ID : $contextID;
        View::render('single-column', 'listing', ['contextID' => $contextID, 'postType' => get_post_type()]);
    }
}
