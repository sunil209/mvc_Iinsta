<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar', ['menuClass' => 'navbar-white']);
Component::render('columns');
Component::render(
    'left-right',
    [
        'leftRightSlot' => Component::fetch('benefits-section', 'side-column')
    ]
);
Component::render('benefits-section', ['class' => 'v7-mt-lg-100 v7-product-page']);
Component::render('patterned-tiles', ['class' => 'v7-patterned-tile-orange']);
Component::render('background-gradient');
Component::render('testimonials-slider');
Component::render('cta-section');
Component::render('v51/footer');
Component::render('v51/document-end');
