<?php
add_action('init', 'registerDictionaryPosttype', 1);
add_action('wp', 'removeRelLinkFromDictionary', 1);

function removeRelLinkFromDictionary() {
  if (isDictionary()) {
    add_filter('wpseo_next_rel_link', '__return_false');
    add_filter('wpseo_prev_rel_link', '__return_false');
  }
}

function registerDictionaryPosttype() {
  $labels = [
    'name' => __('Dictionary terms'),
    'singular_name' => __('Dictionary term'),
    'add_new_item' => __('Add new term'),
    'edit_item' => __('Edit term'),
    'new_item' => __('New term'),
    'view_item' => __('View term'),
    'search_items' => __('Search terms'),
    'not_found' => __('No terms'),
  ];

  $supports = [
    'title',
    'revisions',
    'thumbnail',
  ];

  $rewrite = [
    'with_front' => false,
    'slug' => 'marketing-dictionary',
    'feeds' => false,
    'pages' => false
  ];

  $args = [
    'labels' => $labels,
    'supports' => $supports,
    'rewrite' => $rewrite,
    'exclude_from_search' => true,
    'hierarchical' => true,
    'public' => true,
    'has_archive' => true,
    'menu_icon' => get_template_directory_uri() . '/v5/assets/images/book_grey.svg',
    'capability_type' => ['dictionary_term', 'dictionary_term'],
    'capabilities' => [
      'read_post' => 'read_dictionary_term',
      'publish_posts' => 'publish_dictionary_terms',
      'edit_posts' => 'edit_dictionary_terms',
      'edit_others_posts' => 'edit_others_dictionary_terms',
      'delete_posts' => 'delete_dictionary_terms',
      'delete_others_posts' => 'delete_others_dictionary_terms',
      'read_private_posts' => 'read_private_dictionary_terms',
      'edit_post' => 'edit_dictionary_term',
      'delete_post' => 'delete_dictionary_term',
    ],
    'map_meta_cap' => true
  ];

  register_post_type('dictionary-term', $args);
}

function isDictionary() {
  $post = get_post();

  if (!$post || $post->post_type !== 'dictionary-term') {
    return false;
  }

  return true;
}

function getFirstLetter($string) {
  return strtoupper(substr(trim($string), 0, 1));
}

function getDictionaryRelatedTermsObjects($termId) {
  $relatedTerms = get_field('related_terms', $termId);

  foreach ($relatedTerms as &$term) {
    $term->link = get_permalink($term);
  }

  return $relatedTerms;
}

function cleanDictionaryKeywords($string) {
  return trim(str_replace(' ', '+',  $string));
}

function getDictionaryRelatedTerms($termId) {
  $items = [];

  $relatedTerms = getDictionaryRelatedTermsObjects($termId);
  if (!empty($relatedTerms)) {
    foreach ($relatedTerms as $term) {
      $items[] = [
        'name' => $term->post_title,
        'url' => $term->link,
      ];
    }
  }

  return $items;
}
