<?php
use \Instapage\Classes\Component;

Component::render(
    'image-repeater',
    'boilerplate',
    [
        'sectionClass' => 'v7-content-overflow-hidden',
        'containerClass' => 'v7-group-animation-wrapper js-v7-group-animation-container',
        'imageClass' => 'v7-group-animation',
        'sectionTitle' => $sectionTitle,
        'sectionSubtitle' => $sectionSubtitle,
        'images' => $images
    ]
);
