<?php

use Instapage\Classes\Component;

$tilesTitle = 'More Content for You';
$tiles = [
  [
    'image' => get_template_directory_uri() . '/v5/assets/images/icon-gdpr.svg',
    'title' => 'GDPR',
    'url' => site_url() . '/gdpr',
    'moreText' => 'More info'
  ],
  [
    'image' => get_template_directory_uri() . '/v5/assets/images/icon-security.svg',
    'title' => 'Security',
    'url' => site_url() . '/security',
    'moreText' => 'More info'
  ],
  [
    'image' => get_template_directory_uri() . '/v5/assets/images/icon-help.svg',
    'title' => 'Help Center',
    'url' => 'https://help.instapage.com/hc/en-us',
    'moreText' => 'More info'
  ],
];

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render(
    'header',
    [
    'contextID' => $contextID,
    'headerSlot' => Component::fetch(
        'search',
        'shadow-listing',
        [
            'placeholder' => 'Search...',
            'postType' => $postTypes,
            'searchType' => 'resources'
        ]
    )
    ]
);
Component::render('featured-article');
Component::render('tiles', ['layout' => 'four', 'class' => 'v7-tiles-colored']);
Component::render('posts-browser');
Component::render('tiles', ['sectionTitle' => $tilesTitle, 'tiles' => $tiles]);
Component::render('cta-section', ['isGlobalAcf' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');
