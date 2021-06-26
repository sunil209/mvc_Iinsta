<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar', [
    'menuClass' => 'navbar-white',
    'contextID' => $contextID
]);
Component::render('header', ['contextID' => $contextID]);
Component::render('listing', [
    'listingTitle' => 'View case studies',
    'isAuthor' => false
]);
Component::render('v51/footer');
Component::render('v51/document-end');
