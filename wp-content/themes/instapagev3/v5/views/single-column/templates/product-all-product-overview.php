<?php
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar', ['menuClass' => 'navbar-white']);
Component::render('header', 'solid');
Component::render('left-right', ['class' => 'v7-left-right-spread']);
Component::render('left-right');
Component::render('feature');
Component::render('background-gradient');
Component::render('testimonials-slider');
Component::render('cta-section', ['backgroundLight' => true, 'backgroundGradientLight' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');
