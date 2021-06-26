<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header', ['headerClass' => 'v7-header-top']);
Component::render('pricing-cards', ['isExpanded' => true]);
// Component::render('pricing-card-tabs', ['isExpanded' => true]);
Component::render('feature', ['class' => 'v7-mt-md-60']);
Component::render('simple-sections');
Component::render('image-repeater');
Component::render('background-gradient');
Component::render('accordion', ['sectionClass' => 'v7-content', 'isEditable' => false]);
Component::render('testimonials-slider');
Component::render('cta-section');
Component::render('v51/document-end');
