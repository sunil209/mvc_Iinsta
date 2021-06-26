<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar', ['menuClass' => 'navbar-button-ghost']);
Component::render('header', 'solid', ['headerClass' => 'is-dark v7-landing-page-templates-header']);
Component::render(
    'posts-browser',
    'thumbnails',
    [
        'title' => __('Categories'),
        'categories' => $categories,
        'templates' => $templates
    ]
);
Component::render('cta-section', ['backgroundLight' => true, 'backgroundGradientLight' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');
