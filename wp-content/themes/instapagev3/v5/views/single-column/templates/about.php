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
Component::render('logos');
Component::render('expandable-tiles');
Component::render('v51/carousel', 'single');
Component::render('filter');
Component::render('panel-section');
Component::render('v51/footer');
Component::render('v51/document-end');
