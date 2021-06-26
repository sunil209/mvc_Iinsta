<?php
use \Instapage\Classes\Component;

Component::render(
    'image-repeater',
    'boilerplate',
    [
        'containerClass' => 'v7-image-grid',
        'imageClass' => 'v7-image-grid-item',
        'sectionTitle' => $sectionTitle,
        'sectionSubtitle' => $sectionSubtitle,
        'images' => $images
    ]
);
