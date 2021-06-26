<?php
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar', ['contextID' => $contextID]);
Component::render(
    'header',
    [
        'doNotCache' => true,
        'contextID' => $contextID,
        'headerSlot' => Component::fetch(
            'search',
            'shadow-listing',
            [
                'doNotCache' => true,
                'value' => $querySearch,
                'postType' => $postType,
                'searchType' => $searchType
            ]
        )
    ]
);

?>
<main class="v7 v7-search-listing v7-mb-100">
<?php if (have_posts() && trim($querySearch) != '') {
    Component::render('listing', [
        'doNotCache' => true,
        'listingTitle' => sprintf(__('Search results for &quot;%s&quot;:'), $querySearch)
    ]);
} else {
    Component::render('no-result', [
        'doNotCache' => true,
        'listingTitle' => sprintf(__('Sorry, your search for &quot;%s&quot; had no results.'), $querySearch),
        'listingSubtitle' => 'Please try again, but with different keywords.'
    ]);
} ?>
</main>
<?php
Component::render('cta-section', ['contextID' => $contextID]);
Component::render('v51/footer');
Component::render('v51/document-end');
