<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;
use Instapage\Models\Resources;

class ResourcesDispatcher {
    public function __construct()
    {
        $page = getV5Page();
        /** @var Resources $model */
        $model = Factory::getModel($page);
        $categories = $model->getCategories();
        $postTypes = $model->getPostTypes();

        View::render(
            'single-column',
            'resources',
            [
                'categories' => $categories,
                'postTypes' => $postTypes,
                'model' => $model
            ]
        );
    }
}
