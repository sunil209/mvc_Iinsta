<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;

class FeatureDispatcher
{
    public function __construct()
    {
        $page = getV5Page();
        $model = Factory::getModel($page);
        $contextID = $model->getContextID();
        $params['contextID'] = $contextID instanceof \WP_Post ? $contextID->ID : $contextID;

        if (is_single()) {
            global $post;
            $model->disableRobotsAndRemoveCanonical($post);
            $params['post'] = $post;
            $params['benefits'] = $model->getBenefits($post->ID);
            $params['ID'] = get_the_ID();
            if (isAmp()) {
                View::render('amp', 'single-feature', $params);
            } else {
                View::render('single-column', 'single-feature', $params);
            }
        } else {
            $params['categories'] = $model->getTaxonomy($model->relatedTaxonomy);
            $params['accordions'] = $model->getAccordions();

            View::render('dual-column', 'feature', $params);
        }
    }
}
