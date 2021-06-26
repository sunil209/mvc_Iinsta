<?php
// Version 3 - It won the a/b test so its original version now
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('logo-bar');
?>
<section class="v7 v7-bg-royal v7-header-spacing">
    <?php
    Component::render('division-header', [
        'class' => 'v7-content is-narrow v7-pb-40 v7-pb-md-50 white'
    ]);
    Component::render(
        'form',
        'single-step-demo',
        [
            'class' => 'v7-insta-loader'
        ]
    );
    ?>
</section>
<?php
Component::render(
    'benefits-section',
    'columns',
    [
        'sectionClass' => 'v7-bg-royal v7-pb-60',
        'containerClass' => 'white',
    ]
);
Component::render('logos');
Component::render('simple-footer', 'links');
Component::render('v51/document-end');
