<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar', ['menuClass' => 'navbar-button-ghost']);
Component::render('header');
Component::render('benefits-section', 'jumbo-tiles', ['benefitsClass' => 'v7-benefits-jumbo-big']);
Component::render('panel-section');
Component::render('cta-section');
Component::render('v51/footer');
Component::render('v51/document-end');
