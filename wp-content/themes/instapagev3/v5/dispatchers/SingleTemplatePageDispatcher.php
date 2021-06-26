<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\View;
use Instapage\Classes\Factory;
use Instapage\Classes\Templates\ClassTemplates;

class SingleTemplatePageDispatcher
{
    public function __construct()
    {
        if (!is_404()) {
            if (isAmp()) {
                View::render('amp', 'template');
            } else {
                $model = Factory::getModel('landing-page-templates');
                $template = $model->getTemplate(ClassTemplates::getCurrentTemplateSlug(), true);
                $params['categories'] = $model->getCategories();
                $params['template'] = $template;
                $params['similarTemplates']  = $model->getSimilarTemplates($template, 3);
                $params['archiveSlug'] = $model->archiveSlug;

                add_filter('wp_title', function () use ($template) {
                    return $template->name;
                }, 1, 0);

                add_filter('body_class', function ($classes) {
                    $newClasses = [];
                    $excludedClasses = ['home'];
                    if (is_array($classes) && (!empty($classes))) {
                        foreach ($classes as $class) {
                            if (!in_array($class, $excludedClasses)) {
                                $newClasses[] = $class;
                            }
                        }
                    }
                    return $newClasses;
                });

                View::render('single-column', 'template', $params);
            }
        } else {
            View::render('single-column', '404');
        }
    }
}
