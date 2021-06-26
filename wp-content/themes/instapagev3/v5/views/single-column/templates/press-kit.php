<?php
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header');
?>

<section class="v7 v7-content v7-mt-80">
    <?php Component::render('division-header'); ?>
</section>
<?php Component::render('download-logos'); ?>
<section class="v7 v7-mt-80">
    <?php
    Component::render('division-header', [
        'class' => 'v7-content is-narrow v7-mb-40 v7-mb-md-50'
    ]);
    Component::render('colors');
    ?>
</section>

<?php
Component::render(
    'image-repeater',
    'grid',
    [
        'gridClass' => 'col-sm-12 col-md-6',
        'imageClass' => 'v7-mx-auto v7-pb-10 img-responsive'
    ]
);
Component::render('download-resources');
Component::render('v51/footer');
Component::render('v51/document-end');
