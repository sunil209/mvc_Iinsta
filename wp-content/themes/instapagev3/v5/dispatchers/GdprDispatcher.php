<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\Factory;
use Instapage\Classes\View;

class GdprDispatcher
{
    public function __construct()
    {
        $page = getV5Page();
        $model = Factory::getModel($page);
        $accordionsAndCategories = $model->getAccordionsAndCategories($page);
     
        View::render('dual-column', 'acf-categories-accordion', $accordionsAndCategories);
    }
}
