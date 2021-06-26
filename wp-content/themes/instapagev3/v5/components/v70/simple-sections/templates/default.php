<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title        A title of a section
 * @param string $subtitle     A subtitle of a section
 * @param array  $button       An array containing text, url, class and button type
 * @param array  $image        An array of image data like src and sizes
 * @param array  $imageRetina  An array of retina image data like src and sizes
 *
 * @example Usage
 * Component::render('simple-sections');
 * @endexample
 */

use \Instapage\Classes\Component;

if (empty($title)) {
    return;
}
?>

<section class="v7 v7-mt-80">
    <?php
    if (!empty($title)) {
        Component::dumbRender('division-header', [
            'title' => $title,
            'subtitle' => $subtitle ?? '',
            'class' => 'v7-mb-30 v7-mb-md-40 v7-content is-narrow'
        ]);
    }

    if (!empty($button)) : ?>
    <div class="v7-content is-narrow text-center v7-mb-20">
        <?php Component::render('button', $button); ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($image)) : ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php Component::render(
                    'v51/image',
                    [
                        'image' => $image ?? '',
                        'imageRetina' => $imageRetina ?? '',
                        'class' => 'img-responsive v7-mx-auto',
                        'onlyLazyImageClass' => true
                    ]
                ); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>
