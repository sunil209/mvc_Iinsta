<?php
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render(
    'v51/navbar',
    [
        'desktopNavbarMenu' => Component::fetch(
            'v51/navbar-menu',
            [
                'btnClass'=> 'btn-white',
                'items' => getV5Menu('v5-top-menu')
            ]
        ),
        'mobileNavbarMenu' => Component::fetch(
            'v51/navbar-menu',
            'mobile',
            [
                'items' => getV5Menu('v5-top-menu'),
                'mobileClass' => 'navbar-white'
            ]
        )
    ]
);
Component::render('header');
Component::render('tiles', get_field('tile_layout') ?? 'default');
Component::render('benefits-section');
Component::render('image-repeater');
Component::render('background-gradient');
Component::render('accordion', ['sectionClass' => 'v7-content', 'isEditable' => true]);
Component::render('cta-section');
Component::render('v51/document-end');
