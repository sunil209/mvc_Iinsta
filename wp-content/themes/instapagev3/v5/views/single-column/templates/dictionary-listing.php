<?php
use Instapage\Classes\Component;

Component::render('v51/document-start', ['contextID' => $contextID]);
Component::render('v51/navbar', ['menuClass' => 'is-shadowless', 'contextID' => $contextID]);
Component::render(
    'header',
    [
      'contextID' => $contextID,
      'headerSlot' => Component::fetch('search', 'shadow', ['placeholder' => 'Search...'])
    ]
);
Component::render(
    'division-header',
    [
        'class' => 'v7 v7-mt-80 v7-mb-40 v7-content is-narrow',
        'title' => __('The Ultimate Marketing Dictionary'),
        'subtitle' => __('Instapage has compiled a list of the terms and definitions every digital marketer needs to know to stay in tune with an ever-changing industry.')
    ]
);
Component::render('alphabet-bar', ['items' => $barItems]);
Component::render('alphabet-list', ['items' => $listingItems]);
Component::render('cta-section', ['contextID' => $contextID, 'backgroundDark' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');
