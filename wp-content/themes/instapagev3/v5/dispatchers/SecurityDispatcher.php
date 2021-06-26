<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;

class SecurityDispatcher
{
    public function __construct()
    {
        $page = getV5Page();
        $model = Factory::getModel($page);
        $accordionsAndCategories = $model->getAccordionsAndCategories($page);

        View::render('dual-column', 'acf-categories-accordion', $accordionsAndCategories);
    }
}
