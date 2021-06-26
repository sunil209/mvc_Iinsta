<?php
/**
 * Template file. Template params are stored in $params array
 *
 */
use Instapage\Classes\{
    Component,
    Data
};


if (isset($is_ajax) && $is_ajax === true) {
    foreach ($posts as $post) {
        Component::render('panel', 'listing', $post);
    }

    return;
}
if (!empty($listingTitle)) : ?>
    <section class="v7 v7-content v7-mt-80 v7-listing-header">
        <?php
        Component::dumbRender('division-header', [
            'doNotCache' => true,
            'title' => $listingTitle,
            'class' => 'v7-listing-title v7-mb-20 v7-mb-md-30'
        ]);
        Component::render(
            'dropdown',
            ['title' => $categories['current'], 'icon' => true, 'options' => $categories['all']]
        );
        ?>
    </section>
    <section class="v7-content v7-mt-30 v7-mt-md-50">
    <?php
else :?>
    <section class="v7-content v7-mt-80">
    <?php
endif; ?>

    <div
        class="v7 v7-double-panel-container"
        id="js-load-more-content"
        data-current-page="<?= $currentPageNumber ?>"
        data-max-page-number="<?= $maxPageNumber ?>"
        data-post-types='<?= json_encode($postTypes) ?>'
        <?= is_author() ? 'data-author-id="' . $authorId . '"' : '' ?>
        <?= is_category() ? 'data-category-name="' . $categoryName . '"' : ''?>
        <?= is_search() ? 'data-search-query="' . $searchQuery . '"' : '' ?>
        <?= ($searchType = Data::_get('search_type')) !== null
            ? 'data-search-type="' . $searchType . '"'
            : ''
        ?>
    >
        <?php
        foreach ($posts as $post) {
            Component::render('panel', 'listing', $post);
        }
        ?>
    </div>
</section>

<div class="v7-load-more-wrapper load-more-wrapper loader-wrapper js-load-more" style="display:none">
    <div class="loader js-loader" data-state="hidden"></div>
    <div class="v7-btn-group">
        <?php
        Component::render('button', [
            'text' => __('LOAD MORE CONTENT'),
            'url' => '#',
            'class' => 'v7-btn-cta js-load-more-button'
            ]);
        ?>
    </div>
</div>
