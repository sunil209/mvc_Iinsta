<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar', ['contextID' => $contextID]);
Component::render(
    'header',
    [
        'contextID' => $contextID,
        'headerSlot' => Component::fetch(
            'search',
            'shadow-listing',
            [
                'placeholder' => 'Search...',
                'postType' => $postType
            ]
        )  
    ]
);

if (!is_author() && !is_category()) {
    Component::render('featured-article', ['contextID' => $contextID]);
}

Component::render('listing', ['listingTitle' => 'Blog Articles']);
Component::render('cta-section', ['contextID' => $contextID]);
Component::render('v51/footer');
Component::render('v51/document-end');
