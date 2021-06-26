<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header');
Component::render('logos');
Component::render('left-right');
Component::render('panel-section');
Component::render('benefits-section');
Component::render('background-gradient');
Component::render('panel-section');
Component::render('left-right', ['class' => 'customers-logos']);
Component::render('tiles', ['layout' => 'four']);
Component::render('cta-section');
Component::render('v51/footer');
Component::render('v51/document-end');
