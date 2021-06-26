<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header', 'solid', ['headerClass' => 'is-dark v7-header-short-img']);
Component::render('logos', ['logosClass' => 'v7-section-darker', 'logosSpacing' => 'v7-pt-50']);
Component::render(
    'panel-section',
    [
        'sectionClass' => 'v7-section-darker v7-pt-80 v7-flat-panel-circle-btn-wrapper',
        'gaCategory' => 'Product Cards',
        'class' => 'v7-box-clickable v7-shadow-1 v7-flat-panel-with-circle-btn',
        'circleBtn' => true
    ]
);
Component::render('left-right');
Component::render('testimonials-slider');
Component::render('cta-section', ['backgroundDark' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');
