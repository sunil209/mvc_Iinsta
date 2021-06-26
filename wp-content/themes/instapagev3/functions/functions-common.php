<?php
/**
 * Registers custom post types
 */
abstract class CustomPostType {
  public static $postType;
  public static $nameSingular;
  public static $namePlural;
  public static $slug;
  public static $hasArchive = false;
  public static $priority = 1;
  public static $pages = false;

  public function __construct() {
    add_action('init', [&$this, 'registerPostType'], static::$priority);
    add_filter('wp_title', [&$this, 'setTitle'], 10, 2);
    add_action('wp_head', [&$this, 'setDescription']);
  }

  public function registerPostType() {
    $labels = [
      'name'          => __(ucfirst(static::$namePlural)),
      'singular_name' => __(ucfirst(static::$nameSingular)),
      'add_new_item'  => __('Add new ' . static::$nameSingular),
      'edit_item'     => __('Edit ' . static::$nameSingular),
      'new_item'      => __('New ' . static::$nameSingular),
      'view_item'     => __('View ' . static::$nameSingular),
      'search_items'  => __('Search ' . static::$namePlural),
      'not_found'     => __('No ' . static::$namePlural),
    ];

    $supports = [
      'title',
      'revisions',
      'editor',
      'author',
      'excerpt',
      'thumbnail',
      'page-attributes'
    ];

    $rewrite = [
      'with_front'          => false,
      'slug'                => (isset(static::$slug)) ? static::$slug : 'resources/' . static::$postType,
      'feeds'               => false,
      'pages'               => (isset(static::$pages)) ? static::$pages : true
    ];

    $capabilities = [
      'read_post'           => 'read_' . str_replace(' ', '_', static::$nameSingular),
      'publish_posts'       => 'publish_' . str_replace(' ', '_', static::$namePlural),
      'edit_posts'          => 'edit_' . str_replace(' ', '_', static::$namePlural),
      'edit_others_posts'   => 'edit_others_' . str_replace(' ', '_', static::$namePlural),
      'delete_posts'        => 'delete_' . str_replace(' ', '_', static::$namePlural),
      'delete_others_posts' => 'delete_others_' . str_replace(' ', '_', static::$namePlural),
      'read_private_posts'  => 'read_private_' . str_replace(' ', '_', static::$namePlural),
      'edit_post'           => 'edit_' . str_replace(' ', '_', static::$nameSingular),
      'delete_post'         => 'delete_' . str_replace(' ', '_', static::$nameSingular),
     ];

    $args = [
      'labels'              => $labels,
      'supports'            => $supports,
      'rewrite'             => $rewrite,
      'exclude_from_search' => false,
      'hierarchical'        => true,
      'public'              => true,
      'has_archive'         => static::$hasArchive,
      'capability_type'     => [static::$namePlural, static::$nameSingular],
      'capabilities'        => $capabilities,
      'map_meta_cap'        => true
    ];
    register_post_type(static::$postType, $args);
  }

  public function setTitle($title) {
    if (get_class(static::getLinkedModel()) === 'Instapage\Models\Root') {
      return $title;
    }

    $seoYoastTitle = get_post_meta(static::getLinkedModel()->getContextID()->ID, '_yoast_wpseo_title', true);
    return (static::is() && is_archive() && !empty($seoYoastTitle)) ? $seoYoastTitle : $title;
  }

  public function setDescription($description) {
    if (get_class(static::getLinkedModel()) === 'Instapage\Models\Root') {
      echo $description;
      return;
    }

    $seoYoastDescription = get_post_meta(static::getLinkedModel()->getContextID()->ID, '_yoast_wpseo_metadesc', true);
    $description = (static::is() && is_archive() && !empty($seoYoastDescription)) ? $seoYoastDescription : $description;
    echo (!empty($description)) ? sprintf('<meta name="description" content="%s" />', $description) : '';
  }

  public static function is($postType = null, $post = null) {
    if (is_null($postType)) {
      $postType = static::$postType;
    }

    if (is_null($post)) {
      $post = get_post();
    }

    return (!is_404() && $post && $post->post_type === $postType);
  }

  public static function getLinkedModel() {
    return \Instapage\Classes\Factory::getModel(static::$postType);
  }
}

/**
 * Registers custom taxonomy
 */
abstract class CustomTaxonomy {
  public static $taxonomy;
  public static $relatedPostTypes;
  public static $nameSingular;
  public static $namePlural;
  public static $priority = 1;

  public function __construct() {
    add_action('init', [&$this, 'registerTaxonomy'], static::$priority);
  }

  public function registerTaxonomy() {
    $labels = [
      'name'              => __(ucfirst(static::$namePlural)),
      'singular_name'     => __(ucfirst(static::$nameSingular)),
      'add_new_item'      => __('Add new ' . static::$nameSingular),
      'edit_item'         => __('Edit ' . static::$nameSingular),
      'update_item'       => __('Update ' . static::$nameSingular),
      'new_item'          => __('New ' . static::$nameSingular),
      'new_item_name'     => __('New ' . static::$nameSingular . ' name'),
      'view_item'         => __('View ' . static::$nameSingular),
      'search_items'      => __('Search ' . static::$namePlural),
      'not_found'         => __('No ' . static::$namePlural),
      'parent_item'       => __('Parent ' . static::$nameSingular ),
      'parent_item_colon' => __('Parent ' . static::$nameSingular . ':'),
    ];

    $args = [
      'label'     => __(static::$nameSingular),
      'labels'    => $labels,
      'public'    => true,
      'query_var' => false,
      'rewrite'   => false
    ];

    register_taxonomy(static::$taxonomy, static::$relatedPostTypes, $args);
  }
}
