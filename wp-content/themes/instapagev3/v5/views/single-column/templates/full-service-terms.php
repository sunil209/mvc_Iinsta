<?php
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header');
?>

<div class="v7 v7-content editable-content v7-editable-content v7-mt-50">
    <?php the_content(); ?>
</div>
<?php
Component::render('cta-section', ['isGlobalAcf' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');
