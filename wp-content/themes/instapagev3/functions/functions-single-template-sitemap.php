<?php
use \Instapage\Classes\CustomSitemap\CustomSitemap;
use \Instapage\Classes\CustomSitemap\RootSitemap;
use \Instapage\Classes\Factory;

/**
 * Class defining sitemap for single templates
 */
class SingleTemplateSitemap extends RootSitemap {
  /**
   * @var bool $isEnabled Decides whether use this sitemap or ignore it
   */
  public $isEnabled = true;

  /**
   * @var string $path Holds path under which current sitemap can be accessed
   */
  public $path = 'single-template-websitemap.xml';

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
          'loc' => home_url($template->slug),
          'priority' => '0.5',
          'changefreq' => 'daily'
        ];
      }
    }

    return $data;
  }
}

CustomSitemap::getInstance()->register(
  new SingleTemplateSitemap()
);
