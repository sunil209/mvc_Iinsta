<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render(
    'v51/navbar',
    [
        'isSticky' => true
    ]
);
Component::render('form', 'password');
Component::render('v51/document-end');
