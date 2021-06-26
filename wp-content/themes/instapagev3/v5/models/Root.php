<?php
namespace Instapage\Models;

/**
 * Root model.
 */
class Root {
  /**
   * @var string $postType Holds information about what postType should be used with this model
   */
  public $postType = 'post';

  /**
   * Gets list of categories from ACF
   * @return array
   */
  public function getCategories() {
    $items = [];

    if (have_rows('categories')) {
      while (have_rows('categories')) {
        the_row();
        $items[] = [
          'id' => '#category-' . sanitize_title_with_dashes(get_sub_field('name')),
          'name' => get_sub_field('name')
        ];
      }
    }

    return $items;
  }

  /**
   * Gets the terms of a selected taxonomy.
   *
   * @uses get_categories
   *
   * @param string $taxonomy Name of the taxonomy. Default: 'category'.
   * @param array $args Additional arguments passed to get_categories functiom.
   * See https://developer.wordpress.org/reference/functions/get_terms for details.
   *
   * @return array Terms for selected taxonomy.
   */
  public function getTaxonomy($taxonomy = 'category', $args = []) {
    $items = [];
    $args['taxonomy'] = $taxonomy;
    $terms = get_categories($args);

    if (!empty($terms)) {
      foreach ($terms as $term) {
        $items[] = [
          'id' => 'term-' . sanitize_title_with_dashes($term->name),
          'name' => $term->name,
          'url' => get_term_link($term),
        ];
      }
    }

    return $items;
  }

  /**
   * Gets list of posts matching given criteria
   * @param  array $options Array which will be merged with default values and passed down to get_posts()
   * @uses   self::$postType
   * @return array
   */
  public function getPosts($options = []) {
    $optionsDefault = [
      'post_type' => $this->postType,
      'post_status' => 'publish',
      'posts_per_page' => -1
    ];

    $options = array_merge($optionsDefault, $options);
    $posts = get_posts($options);

    return ((is_array($posts)) && (!empty($posts))) ? $posts : [];
  }

  /**
   * Reorders array of posts prioritizing sticky ones
   * @param  array $posts Array of posts returned from {@see self::getPosts()}
   * @uses   getAcfVar()
   * @return array Array of posts
   */
  public function prioritizeStickyPosts($posts = []) {
    if ((!empty($posts)) && (is_array($posts))) {
      $stickyPosts = [];
      $regularPosts = [];
      foreach ($posts as $post) {
        if (getAcfVar('sticky', false, $post->ID)) {
          $stickyPosts[] = $post;
        } else {
          $regularPosts[] = $post;
        }
      }

      return array_merge($stickyPosts, $regularPosts);
    } else {
      return [];
    }
  }

  /**
   * Pulls the list of post slides for archive page header.
   * @param  string $postType Post type to get the list from.
   * @param  int $limit Limit of posts.
   * @uses   self::$postType
   * @return array List of post slides in proper format.
   */
  public function getPostSlides($postType = 'post', $limit = 3) {
    $args = [
      'post_type' => $this->postType,
      'posts_per_page' => $limit,
      'post_status' => 'publish',
      'meta_key' => 'slider_image',
      'meta_value' => '',
      'meta_compare' => '<>'
    ];

    $posts = get_posts($args);
    $items = [];

    if (!empty($posts)) {
      foreach ($posts as $item) {
        $items[] = [
          'ID' => $item->ID,
          'title' => $item->post_title,
          'url' => get_permalink($item->ID),
          'image' => get_field('slider_image', $item->ID),
          'text' => (has_post_video($item->ID)) ? __('Watch now') : __('Read more')
        ];
      }
    }

    return $items;
  }

  /**
   * Gets testimonials
   * @param  int $contextID (optional) ID of page from which ACF data should be pulled from
   * @param  int $limit (optional) Number of testimonials to return. 0 - return all available testimonials.
   * @return array
   */
  public function getTestimonials($contextID = null, $limit = 0) {
    $items = [];

    if (have_rows('testimonial', $contextID)) {
      while (have_rows('testimonial', $contextID)) {
        the_row();
        $items[] = [
          'name' => get_sub_field('name'),
          'position' => get_sub_field('position'),
          'avatar' => get_sub_field('avatar'),
          'avatarRetina' => get_sub_field('avatar_retina'),
          'logo' => get_sub_field('logo'),
          'logoRetina' => get_sub_field('logo_retina'),
          'comment' => get_sub_field('comment'),
          'image' => get_sub_field('image'),
          'video' => get_sub_field('video'),
          'alignment' => get_sub_field('alignment')
        ];

        if ($limit && count($items) === $limit) {
          break;
        }
      }
    }

    return $items;
  }

  /**
   * Gets the sub-field data from ACF plugin.
   * @param  string $fieldName Name of the field (with subfields).
   * @param  string $subFieldName Name of the sub-field to retrieve.
   * @param  int $contextID (optional) ID of page from which ACF data should be pulled from.
   * @param  string $subFieldAttribute (optional) Name of the attribute to pull. If left empty, whole subfield array will be returned.
   *
   * @return  mixed|array|null Returns value of the selected sub-field attribute, whole sub-field array or null, if either sub-field or sub-field attribute is not found.
   */
  public function getSubField($fieldName, $subFieldName, $contextID = null, $subFieldAttribute = null) {
    if (empty($contextID)) {
      $contextID = get_the_ID();
    }
    $field = get_field_object($fieldName, $contextID);

    if (!isset($field['sub_fields']) || !is_array($field['sub_fields'])) {
      return null;
    }

    foreach ($field['sub_fields'] as $subField) {
      if ($subField['name'] === $subFieldName) {
        if (!empty($subFieldAttribute)) {
          return isset($subField[$subFieldAttribute]) ? $subField[$subFieldAttribute] : null;
        }

        return $subFieldName;
      }
    }
  }

  /**
   * Gets an array with benefits from ACF
   * @return array
   */
  public function getBenefits() {
    $items = [];

    if (have_rows('benefits')) {
      while (have_rows('benefits')) {
        the_row();
        $items[] = [
          'name' => get_sub_field('name'),
          'description' => get_sub_field('description', false),
          'icon' => get_sub_field('icon')
        ];
      }
    }

    return $items;
  }

  /**
   * Adds robots=noindex,nofollow to meta tags and remove canonical tag.
   *
   * Adds robots=noindex,nofollow to meta tags and remove canonical tag,
   * when $post content is empty.
   *
   * @param WP_Post|null $post Post object
   */
  public function disableRobotsAndRemoveCanonical($post = null) {
    if (!isset($post->post_content) || empty($post->post_content)) {
      add_action('wp_head', function($text) {
        echo sprintf('<meta name="robots" content="%s" />', 'noindex,nofollow');
      });

      // removing canonical tag
      add_filter('wpseo_canonical', function ($canonical) {
        return '';
      });
    }
  }

  /**
   * Gets an array with logos from ACF
   * @param  int $contextID (optional) ID of page from which ACF data should be pulled from
   * @return array
   */
  public function getLogos($contextID = null) {
    $items = [];

    if (have_rows('logos', $contextID)) {
      while (have_rows('logos', $contextID)) {
        the_row();
        $items[] = [
          'image' => get_sub_field('image'),
          'imageRetina' => get_sub_field('image_retina'),
          'alt' => get_sub_field('alt')
        ];
      }
    }

    return $items;
  }

  /**
   * Gets an array with slides from ACF
   * @param  int $contextID (optional) ID of page from which ACF data should be pulled from
   * @return array
   */
  public function getSlides($contextID = null) {
    $items = [];

    if (have_rows('slides', $contextID)) {
      while (have_rows('slides', $contextID)) {
        the_row();
        $items[] = [
          'class' => get_sub_field('class'),
          'image' => get_sub_field('image'),
          'imageRetina' => get_sub_field('image_retina'),
          'text' => get_sub_field('text'),

          'avatarName' => get_sub_field('avatar_name'),
          'avatarInfo' => get_sub_field('avatar_info'),
          'avatarImage' => get_sub_field('avatar_image'),
          'avatarImageRetina' => get_sub_field('avatar_image_retina'),

          'videoUrl' => get_sub_field('video_url')
        ];
      }
    }

    return $items;
  }
}
