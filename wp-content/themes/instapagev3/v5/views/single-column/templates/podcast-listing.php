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
Component::render('buttons-group', 'subscribe');
Component::render('listing');
Component::render('cta-section', ['isGlobalAcf' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');
