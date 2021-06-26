<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header', ['headerClass' => 'v7-header-top']);
Component::render('pricing-card-tabs', ['isExpanded' => true]);
Component::render('simple-sections');
Component::render('image-repeater');
Component::render('background-gradient');
Component::render('accordion', ['sectionClass' => 'v7-content', 'isEditable' => false]);
Component::render('testimonials-slider-new');
Component::render('cta-section');
Component::render('v51/document-end');