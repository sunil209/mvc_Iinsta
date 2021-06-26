<?php
/**
 * Template params are stored in $params array
 *
 * @param string $title        String for component section title
 * @param array  $categories   Array of post types labels.
 *        @param string $id               Id for the category
 *        @param string $name             Name to be displayed
 *        @param string $url              Url or hash for anchor
 *        @param string $class            Class to be added to category for JS manipulation
 *        @param array  $attributes       Attributes to be added to category for JS manipulation
 *               @param string $data-category    Attribute for filtering by a category
 * @param array  $templates        Array of all templates' thumbnails, to be passed to Thubnails component.
 *        @param string $slug             Slug to single page within that post type
 *        @param string $name             Name of the template
 *        @param string $website_image    Url the image of a topfold
 *        @param string $image            Url the image of a topfold in better quality
 *        @param string $class            Class for filtering by category
 *        @param bool   $showListing      Boolean that determins showing template in this component
 *        @param bool   $showListing      Boolean that determins overlay
 *
 * @example Default
 *  Component::render(
 *      'posts-browser',
 *      'thumbnails',
 *      [
 *          'title' => __('Categories'),
 *          'categories' => $categories,
 *          'templates' => $templates
 *      ]
 *  );
 *
 * @endexample
 *
 */
use \Instapage\Classes\Component;

?>

<section class="v7 v7-content v7-mt-80 v7-template-dual-column v7-thumbnails-browser">
    <?php Component::render(
        'sidebar',
        [
            'filter' => true,
            'title' => __('Categories'),
            'options' => $categories,
            'sidebarClass' => 'js-sidebar',
            'sidebarMobile' => Component::fetch('select', [
                'options' => $categories,
                'filter' => true,
                'title' => __('All Categories'),
                'selectClass' => 'v7-sidebar-select',
                'name' => 'all-categories'
            ])
        ]
    );
    Component::render('thumbnails', ['templates' => $templates]); ?>
</section>
