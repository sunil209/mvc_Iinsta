<?php
namespace Instapage\Dispatchers;

use \Instapage\Classes\Factory;
use Instapage\Classes\View;

class LandingPageTemplatesDispatcher
{
    public function __construct()
    {
        $page = getV5Page();
        $model = Factory::getModel($page);

        $params['categories'] = $model->getCategories();
        $params['templates'] = $model->getTemplates();

        View::render('dual-column', 'templates', $params);
    }
}
