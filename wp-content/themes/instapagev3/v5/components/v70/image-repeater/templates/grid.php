<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $images            An array images
 * @param string $sectionClass
 * @param string $containerClass
 * @param string $gridClass
 * @param string $imageClass
 *
 * @example Usage
 * Component::render(
 *     'image-repeater',
 *     'grid',
 *     [
 *         'gridClass' => 'col-sm-12 col-md-6',
 *         'imageClass' => 'v7-mx-auto v7-pb-10 img-responsive'
 *     ]
 * );
 * @endexample
 */

use \Instapage\Classes\Component;

if (empty($images) || !is_array($images) || empty($images[0])) {
    return;
}
?>

<section class="v7 v7-mt-80 <?= esc_attr($sectionClass) ?>">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    }
    ?>
    <div class="container <?= esc_attr($containerClass) ?>">
        <div class="row">

            <?php foreach ($images as $image) : ?>
                <div class="<?= esc_attr($gridClass) ?>">
                    <?php Component::render(
                        'v51/image',
                        [
                            'image' => $image['image'] ?? '',
                            'imageRetina' => $image['image_retina'] ?? '',
                            'class' => $imageClass,
                            'onlyLazyImageClass' => true
                        ]
                    ); ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
