<?php
use \Instapage\Classes\CustomSitemap\CustomSitemap;
use \Instapage\Classes\CustomSitemap\RootSitemap;

/**
 * Class defining sitemap for amp-enabled urls
 */
class AmpPostSitemap extends RootSitemap {
  /**
   * @var bool $isEnabled Decides whether use this sitemap or ignore it
   */
  public $isEnabled = true;

  /**
   * @var string $path Holds path under which current sitemap can be accessed
   */
  public $path = 'amp-post-websitemap.xml';

  /**
   * Returns data for sitemap template
   * @uses  \Instapage\Models\Root::getPosts()
   * @return array
   */
  public function getData() {
    $data = [];

    $model = new \Instapage\Models\Root();
    $posts = $model->getPosts([
      'meta_key' => 'enable_amp',
      'meta_compare' => '=',
      'meta_value' => '1'
    ]);

    if (!empty($posts)) {
      foreach ($posts as $post) {
        $data[] = [
          'loc' => str_replace('/blog/', '/amp/', get_permalink($post->ID)),
          'priority' => '0.5',
          'changefreq' => 'daily',
          'lastmod' => get_the_modified_date(\DateTime::W3C, $post->ID)
        ];
      }
    }

    return $data;
  }
}

CustomSitemap::getInstance()->register(
  new AmpPostSitemap()
);
