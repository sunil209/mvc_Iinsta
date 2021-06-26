<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string        $formClass              Class for form tag
 * @param string        $searchType             Search type, for example `resources`
 * @param string        $placeholder            Placeholder for input
 * @param string        $value                  Value for search input
 * @param string|array  $postType               If array given this search allows to search in many post types
 *
 * @example Default
 *  Component::render(
 *    'header',
 *    [
 *      'headerSlot' => Component::fetch('search', 'shadow-listing', [
 *         'placeholder' => 'Search...',
 *         'postType' => 'post'
 *       ])
 *    ]
 * );
 *
 * @endexample
 *
 */

use \Instapage\Classes\Component;

?>
<div class="v7-search-shadow-wrapper v7-mt-40 v7-mt-md-60">
    <form
        role="search"
        method="get"
        class="v7-search-shadow v7-mx-auto <?= $formClass ?? '' ?>"
        action="<?= site_url() ?>"
    >
        <input
            class="v7-search-input v7-search-input-shadow has-btn"
            placeholder="<?= esc_attr($placeholder ?? ' ') ?>"
            type="text"
            name="s"
            value="<?= esc_attr($value ?? '') ?>"
            autocomplete="off"
        >
        <?php
            Component::render(
                'input',
                'hidden',
                [
                    'name' => 'post_type',
                    'value' =>  $postType ?? ''
                ]
            );
        ?>
        <?php
        if (!empty($searchType)) {
            Component::render(
                'input',
                'hidden',
                [
                    'name' => 'search_type',
                    'value' =>  $searchType
                ]
            );
        }
        ?>
        <span role="icon" class="material-icons v7-search-icon">search</span>
        <button type="submit" class="v7-btn v7-btn-cta v7-search-shadow-btn">
            <?= __('SEARCH NOW') ?>
        </button>
    </form>
</div>
