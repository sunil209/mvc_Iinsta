<?php
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header', ['scrollToSelector' => '#top']);
?>
<section class="v7-mb-80 v7-mb-lg-100" id="top">
    <?php Component::render('panel-section'); ?>
    <?php Component::render('tiles', ['layout' => 'four']); ?>
</section>
<?php
Component::render('v51/footer');
Component::render('v51/document-end');
