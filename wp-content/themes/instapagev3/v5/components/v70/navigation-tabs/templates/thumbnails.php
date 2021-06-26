<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $categories   Array of post types labels.
 *        @param string $id               Id for the category
 *        @param string $name             Name to be displayed
 *        @param string $url              Url or hash for anchor
 *        @param string $class            Class to be added to category for JS manipulation
 *        @param array  $attributes       Attributes to be added to category for JS manipulation
 *               @param string $data-category    Attribute for filtering by a category
 *
 * @example Usage
 * Component::render('navigation-tabs', 'thumbnails');
 * @endexample
 */

use \Instapage\Helpers\HtmlHelper;
?>

<ul class="v7-navigation-tabs v7-thumbnails-browser-navigation v7-mt-40">
    <?php foreach ($categories as $key => $category) : ?>
        <li>
            <a
                class="v7-navigation-tabs-item h5 <?= esc_attr($category['class'] ?? ''); ?>"
                <?= HtmlHelper::renderAttributes($category['attributes'] ?? ''); ?>
                <?= $key === 0 ? 'data-state="active"' : '' ?>
                href="<?= esc_url($category['url'] ?? $category['id'] ?? ''); ?>"
            >
                <?= esc_html($category['name'] ?? '') ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
