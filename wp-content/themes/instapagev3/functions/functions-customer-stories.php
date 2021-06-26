<?php

add_action('init', 'registerCustomerStoriesPosttype', 1);

function registerCustomerStoriesPosttype()
{
    $post_type = 'customer-stories';

    $labels = array(
        'name' => __('Customer Stories'),
        'singular_name' => __('Customer Stories'),
        'add_new_item' => __('Add new customer story'),
        'edit_item' => __('Edit customer story'),
        'new_item' => __('New customer story'),
        'view_item' => __('View customer story'),
        'search_items' => __('Search Customer Stories'),
        'not_found' => __('No Customer Stories'),
    );

    $supports = array(
        'title',
        'revisions',
        'editor',
        'excerpt',
        'thumbnail',
        'page-attributes',
        'author'
    );

    $rewrite = array(
        'with_front' => false,
        'slug' => 'customer-stories',
        'feeds' => false,
        'pages' => true
    );

    $args = array(
        'labels' => $labels,
        'supports' => $supports,
        'rewrite' => $rewrite,
        'exclude_from_search' => false,
        'hierarchical' => true,
        'public' => true,
        'has_archive' => true,
        'capability_type' => array('customer story', 'customer stories'),
        'capabilities' => array(
            'read_post' => 'read_customer_story',
            'publish_posts' => 'publish_customer_stories',
            'edit_posts' => 'edit_customer_stories',
            'edit_others_posts' => 'edit_others_customer_stories',
            'delete_posts' => 'delete_customer_stories',
            'delete_others_posts' => 'delete_others_customer_stories',
            'read_private_posts' => 'read_private_customer_stories',
            'edit_post' => 'edit_customer_story',
            'delete_post' => 'delete_customer_story',
        ),
        'map_meta_cap' => true,
        'menu_icon' => get_template_directory_uri() . '/v5/assets/images/case-study-icon-wp.svg'
    );

    register_post_type($post_type, $args);
}
