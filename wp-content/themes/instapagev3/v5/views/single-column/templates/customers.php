<?php
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render(
    'v51/navbar',
    [
        'menuClass' => 'navbar-white',
        'desktopNavbarMenu' => Component::fetch(
            'v51/navbar-menu',
            [
                'btnClass' => 'btn-cta',
                'items' => $topMenu
            ]
        ),
        'mobileNavbarMenu' => Component::fetch(
            'v51/navbar-menu',
            'mobile',
            [
                'items' => $topMenu,
                'mobileClass' => 'navbar-white'
            ]
        )
    ]
);
Component::render('header');
Component::render('tiles', get_field('tile_layout'));
Component::render('panel-section');
Component::render('left-right');
Component::render('testimonials-slider');
Component::render('cta-section');
Component::render('v51/footer');
Component::render('v51/document-end');
