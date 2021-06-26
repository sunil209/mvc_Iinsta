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
Component::render('listing');
Component::render('cta-section', ['contextID' => $contextID]);
Component::render('v51/footer');
Component::render('v51/document-end');
