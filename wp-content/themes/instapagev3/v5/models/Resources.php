<?php
namespace Instapage\Models;

use \Instapage\Classes\Factory;
use \Instapage\Helpers\StringHelper;

/**
 * Model for /resources page
 */
class Resources extends Root {
  /**
   * Gets list of categories from ACF
   * @return array
   */
  public function getCategories() {
    $items = [];

    if (have_rows('categories')) {
      while (have_rows('categories')) {
        the_row();
        $id = 'category-' . sanitize_title_with_dashes(get_sub_field('name'));
        $url = '#' . $id;
        $dataSourceName = get_sub_field('data_source_name');
        $dataSourceValue = get_sub_field('data_source_value');
        $postIds = get_sub_field('post_ids');
        $linkType = get_sub_field('link_type');
        $linkValue = get_sub_field('link_value');
        $archiveUrl = '';

        switch ($linkType) {
          case 'custom_url':  $archiveUrl = $linkValue; break;
          case 'archive_url': $archiveUrl = ($dataSourceName === 'post_type') ? get_post_type_archive_link($dataSourceValue) : $linkValue; break;
          case 'none':        $archiveUrl = ''; break;
          case '':            $archiveUrl = '';
        }

        $items[] = [
          'id' => $id,
          'name' => get_sub_field('name'),
          'url' => $archiveUrl,
          'dataSourceName' => $dataSourceName,
          'dataSourceValue' => $dataSourceValue,
          'postIds' => $postIds,
          'archiveUrl'=> $archiveUrl
        ];
      }
    }

    return $items;
  }

  /**
   * Obtains post data, passes them through {@link \Instapage\Models\Resources::itemToTile()} and returns as
   * a nested array ready to be looped over in template and passed to component
   * @param  array $options - array of options to be passed to {@link \Instapage\Models\Resources::getItems()}
   * @uses   \Instapage\Models\Resources::getItems()
   * @uses   \Instapage\Models\Resources::itemToTile()
   * @return array
   */
  public function getTiles($options = []) {
    $posts = $this->getItems($options);

    $tiles = [];
    if ((is_array($posts)) && (!empty($posts))) {
      foreach ($posts as $post) {
        $tiles[] = $this->itemToTile($post);
      }
    }

    return $tiles;
  }

  /**
   * Gets options to be used with get_posts function
   * @param  array $category - will be merged with default options
   * @return array
   */
  public function getOptions($category) {
    $options = [];
    $defaults = [
      'posts_per_page'   => 3,
      'orderby'          => 'date',
      'order'            => 'DESC',
      'post_status'      => 'publish',
      'suppress_filters' => true,
      'custom_pagination' => false,
    ];

    if ((isset($category['postIds'])) && (!empty($category['postIds']))) {
      $options['include'] = explode(',', $category['postIds']);
      $options['orderby'] = 'post__in';
    } else {
      if ((isset($category['dataSourceName'])) && ($category['dataSourceName'] === 'post')) {
        $options = ['category' => $category['dataSourceValue']];
      } else if ((isset($category['dataSourceName'])) && ($category['dataSourceName'] === 'post_type')) {
        $options = ['post_type' => $category['dataSourceValue']];
      }
    }

    return array_merge($defaults, $options);
  }

  /**
   * Gets posts from database, also gets some data from custom fields
   * @param  $options - array of options to be passed to get_posts()
   * @return array
   */
  protected function getItems($options = []) {
    if (isset($options['post_type']) && $options['post_type'] == 'seo-page') {
      return $this->getItemsSeoPage($options);
    }

    $posts = get_posts($options);

    if ((is_array($posts)) && (!empty($posts))) {
      foreach ($posts as &$post) {
        setup_postdata($post);

        $post->featuredImage = $this->getItemImage($post->ID, 'v5-resources-size');
        $post->featuredImageRetina = $this->getItemImage($post->ID, 'v5-resources-size-retina');
        $post->postExcerpt = get_the_excerpt($post->ID);
        $post->featuredVideo = get_the_post_video_url($post->ID);
        $post->readMoreLink = get_permalink($post->ID);

        # Marketing guides
        $definition = get_field('definition', $post->ID);
        $post->postExcerpt = (!empty($definition)) ? $definition : $post->postExcerpt;

        # Case studies
        $logo = get_field('company_logo', $post->ID);
        $post->logo = (!empty($logo)) ? $logo : '';
        $logoRetina = get_field('company_logo_retina', $post->ID);
        $post->logoRetina = (!empty($logoRetina)) ? $logoRetina : '';
      }
    }

    return $posts;
  }

  protected function getItemsSeoPage($options = []) {
    $options['posts_per_page'] = -1;
    $modifyGlobalQuery = false;
    $posts = Factory::getModel('seo-page')->getPosts($options, $modifyGlobalQuery);

    if ((is_array($posts)) && (!empty($posts))) {
      foreach ($posts as &$post) {
        $post->post_title = $post->title;
        $post->featuredImage = $this->getItemImage($post->ID, 'v5-resources-size');
        $post->featuredImageRetina = $this->getItemImage($post->ID, 'v5-resources-size-retina');
        $post->postExcerpt = $post->excerpt;
        $post->readMoreLink = $post->permalink;
      }
    }

    $posts = array_slice($posts, 0, 3);

    return $posts;
  }

  /**
   * Converts given post data to an array suitable to be passed directly to tile component
   * @param  WP_Post $post
   * @uses   \Instapage\Models\Resources::filterExcerpt()
   * @return array
   */
  private function itemToTile(\WP_Post $post) {

    return [
      'id' => $post->ID,
      'image' => $post->featuredImage,
      'imageRetina' => $post->featuredImageRetina,
      'video' => $post->featuredVideo,
      'logo' => $post->logo,
      'logoRetina' => $post->logoRetina,
      'title' => $this->filterTitle($post->ID, $post->post_title),
      'contentHtml' => StringHelper::truncate(
        $this->filterExcerpt($post->postExcerpt),
        100
      ),
      'readMoreLink' => $post->readMoreLink,
      'readMoreText' => (!empty($post->featuredVideo)) ? 'Watch more' : 'Read more',
      'postType' => get_post_type($post->ID)
    ];
  }

  /**
   * Truncate post title if it's too long.
   * @param  object $post
   * @return string
   */
  private function filterTitle($postID, $postTitle) {
    $guestsCompanyName = get_field('guests_company_name', $postID);
    $podcastTitle = get_field('podcast_title', $postID);

    if (get_post_type($postID) == 'podcast' && !empty($guestsCompanyName) && !empty($podcastTitle)) {
        return $guestsCompanyName . ' ' . __('on') . ' ' . $podcastTitle;
    }

    return $postTitle;
  }

  /**
   * Replaces `Read more >` link from post excerpt.
   * @param  string $excerpt
   * @return string
   */
  private function filterExcerpt($excerpt) {
    $pattern = '/\<a href\="([^"]+)" class\="excerpt-more"\>([^\<]+)\<\/a\>/';
    return preg_replace($pattern, '', $excerpt);
  }

  /**
   * Returns url to specified image size for given post or empty string
   * @param int $postID
   * @param string size
   * @return string
   */
  private function getItemImage($postID, $size) {
    if ((isset($postID)) && (!empty($postID)) && (isset($size)) && (!empty($size))) {
      $image = wp_get_attachment_image_src(
        get_post_thumbnail_id($postID),
        $size
      );

      return ((!empty($image)) && (is_array($image))) ? $image[0] : '';
    } else {
      return '';
    }
  }

    /**
     * Get all post types which are included in resources page
     *
     * @return array
     */
  public function getPostTypes() : array
  {
      $categories = $this->getCategories();
      $postTypeArray = [];

      foreach ($categories as $category) {
          if ($category['url'] === '/blog') {
              $postTypeArray[] = 'post';
          } else {
              $postTypeArray[] = $category['dataSourceValue'];
          }
      }

      return $postTypeArray;
  }
}
