<?php
use \Instapage\Classes\CustomSitemap\CustomSitemap;
use \Instapage\Classes\CustomSitemap\RootSitemap;
use \Instapage\Classes\Factory;
use \Instapage\Classes\Templates\ClassTemplates;

/**
 * Class defining sitemap for amp-enabled urls
 */
class AmpLandingPageTemplates extends RootSitemap {
  /**
   * @var bool $isEnabled Decides whether use this sitemap or ignore it
   */
  public $isEnabled = true;

  /**
   * @var string $path Holds path under which current sitemap can be accessed
   */
  public $path = 'landing-page-templates-amp.xml';

  /**
   * Returns data for sitemap template
   * @uses  \Instapage\Models\LandingPageTemplates::getTemplates()
   * @return array
   */
  public function getData() {
    $data = [];

    $model = Factory::getModel('landing-page-templates');
    $templates = $model->getTemplates();
    foreach ($templates as $template) {
      if ($template->showDetailed) {
        $data[] = [
          'loc' => str_replace(
                     ClassTemplates::slug, 
                     ClassTemplates::ampSlug, 
                     home_url($template->slug)
                   ),
          'priority' => '0.5',
          'changefreq' => 'daily'
        ];
      }
    }

    return $data;
  }
}

CustomSitemap::getInstance()->register(
  new AmpLandingPageTemplates()
);
