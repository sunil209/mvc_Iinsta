<?php
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar', ['menuClass' => 'navbar-white']);
Component::render('header', 'solid');
Component::render('lists', ['class' => 'v7-checklist-background']);
Component::render(
    'left-right',
    [
        'class' => 'v7-mt-lg-100 v7-left-right-spread',
        'listClass' => 'v7-checklist-background'
    ]
);
Component::render('image-repeater');
Component::render('background-gradient');
Component::render('testimonials-slider');
Component::render('cta-section', ['backgroundLight' => true, 'backgroundGradientLight' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');
