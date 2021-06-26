<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar', ['menuClass' => 'navbar-white']);
Component::render('header', 'solid');
Component::render('logos', ['sectionClass' => 'v7-logos-wide v7-mt-max-lg-40']);
Component::render('left-right');
Component::render('news');
Component::render('cta-section');
Component::render('v51/footer');
Component::render('v51/document-end');
