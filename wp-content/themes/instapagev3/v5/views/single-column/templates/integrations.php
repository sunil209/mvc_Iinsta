<?php
use Instapage\Classes\Component;

Component::render('v51/document-start', ['contextID' => $contextID]);
Component::render('v51/navbar', ['contextID' => $contextID]);
Component::render(
    'header',
    [
        'contextID' => $contextID,
        'headerSlot' => Component::fetch(
            'search',
            'shadow-filters',
            [
                'categories' => $categories,
                'tags' => $tags,
                'placeholder' => 'Search...'
            ]
        )
    ]
);
?>

<section class="v7 v7-mt-50 v7-content text-center is-hidden js-search-heading">
    <h2 class="h1"><?= __('Search Results for') ?> “<span class="js-search-keyword"></span>”:</h2>
</section>
<section class="v7 v7-mt-50 js-no-results v7-is-hidden">
    <?php Component::render(
        'no-result',
        [
            'doNotCache' => true,
            'listingTitle' => __('Sorry, your search  had no results.'),
            'listingSubtitle' => 'Please try again, but with different keywords.'
        ]
    ); ?>
</section>
<main class="v7 v7-mt-80">
    <?php Component::render('integrations-list', ['integrationsCategories' => $accordions]); ?>
</main>

<?php
Component::render('v51/footer');
Component::render('v51/document-end');
