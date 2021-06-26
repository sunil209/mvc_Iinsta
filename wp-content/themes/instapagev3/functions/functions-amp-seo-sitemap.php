<?php
use \Instapage\Classes\CustomSitemap\CustomSitemap;
use \Instapage\Classes\CustomSitemap\RootSitemap;

/**
 * Class defining sitemap for amp-enabled urls
 */
class AmpSeoSitemap extends RootSitemap {
  /**
   * @var bool $isEnabled Decides whether use this sitemap or ignore it
   */
  public $isEnabled = true;

  /**
   * @var string $path Holds path under which current sitemap can be accessed
   */
  public $path = 'amp-seo-websitemap.xml';

  /**
   * Returns data for sitemap template
   * @uses  \Instapage\Models\Root::getPosts()
   * @uses  getSeoPageChapters()
   * @return array
   */
  public function getData() {
    $data = [];
    $posts = [];
    $homeUrl = get_home_url();

    $model = new \Instapage\Models\SeoPage();
    $intros = $model->getPosts([
      'meta_key' => 'enable_amp',
      'meta_compare' => '=',
      'meta_value' => '1',
      'post_name_not_like' => '-chapter-',
      'custom_pagination' => false,
      'posts_per_page' => -1
    ], $modifyGlobalQuery = false);

    if (!empty($intros)) {
      foreach ($intros as $intro) {
        $posts[] = $intro;
        $posts = array_merge($posts, getSeoPageChapters($intro));
      }
    }

    if (!empty($posts)) {
      foreach ($posts as $post) {
        $data[] = [
          'loc' => $homeUrl . '/guides-amp' . str_replace($homeUrl, '', get_permalink($post)),
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
  new AmpSeoSitemap()
);
