<?php
namespace Instapage\Dispatchers;

use Instapage\Classes\Factory;
use Instapage\Classes\View;
use Instapage\Models\SeoPage;

class SeoPageDispatcher
{
    public function __construct()
    {
        if (is_single()) {
            $this->singleRoute();
        } else {
            $seoPageModel = new SeoPage();
            View::render(
                'single-column',
                'seo-page-listing',
                ['contextID' => $seoPageModel->getContextID(), 'postType' => $seoPageModel->postType]
            );
        }
    }

    /**
     * Methods generate view for single seo page route, for AMP and non AMP
     *
     * @throws \Instapage\Classes\NoTemplateException
     */
    public function singleRoute() {
        global $post;
        /** @var Instapage\Models\SeoPage $model */
        $model    = Factory::getModel(getV5Page());

        $menuItems = [
            [
                'title' => __('Back to all guides'),
                'url' => get_home_url() . '/guides',
                'classes' => ['back-link']
            ],
            [
                'title' => __('Login'),
                'url' => URL_INSTAPAGE_LOGIN,
                'classes' => []
            ],
            [
                'title' => __('Try Instapage'),
                'url' => URL_INSTAPAGE_SIGNUP,
                'classes' => ['btn']
            ]
        ];

        $viewParams = [
            'backgroundImage' => getSeoPageHeaderBackground(),
            'benefits' => $model->getBenefits(),
            'menuItems' => $menuItems,
            'seoPageChapters' => getSeoPageChapters($post)
        ];

        if (isAmp()) {
            View::render(
                'amp',
                'seo-page-single',
                $viewParams
            );
        } else {
            View::render(
                'single-column',
                'seo-page-single',
                $viewParams
            );
        }
    }
}
