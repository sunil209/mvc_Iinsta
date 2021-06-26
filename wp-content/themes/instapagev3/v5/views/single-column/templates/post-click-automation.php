<?php
use \Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header');
?>
<section class="v7 v7-content v7-mt-80 v7-pca-section">
    <?php Component::render('division-header'); ?>
    <div class="v7-mt-50 text-center">
        <?php Component::render('v51/image', ['constrainMaxWidth' => true]); ?>
    </div>
</section>
<?php
Component::render('background-gradient', ['backgroundGradientPosition' => 'above']);
Component::render('left-right');
Component::render('background-gradient');
Component::render('testimonials-slider');
Component::render('tiles', ['layout' => 'four']);
Component::render('cta-section');
Component::render('v51/footer');
Component::render('v51/document-end');
