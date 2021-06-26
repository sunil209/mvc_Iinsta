<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;

class IntegrationDispatcher
{
    public function __construct()
    {
        if (is_single()) {
            View::render('dual-column', 'single-integration');
        } else {
            $page = getV5Page();
            $model = Factory::getModel($page);
            $contextID = $model->getContextID();
            $categories = $model->getTaxonomy($model->relatedTaxonomy);
            $allCategories = $model->allCategories;

            $params['categories'] = array_merge($allCategories, $categories);
            $params['tags'] = $model->tags;
            $params['accordions'] = $model->getAccordions();
            $params['contextID'] = $contextID instanceof \WP_Post ? $contextID->ID : $contextID;

            View::render('single-column', 'integrations', $params);
        }
    }
}
