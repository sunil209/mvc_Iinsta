<?php
/*
 * Template file.
 *
 * Usage for image repeater cloud with animation:
 * Component::render(
 * 'image-repeater',
 * 'boilerplate',
 *     [
 *         'sectionClass' => 'v7-content-overflow-hidden',
 *         'containerClass' => 'v7-group-animation-wrapper js-v7-group-animation-container',
 *         'imageClass' => 'v7-group-animation'
 *     ]
 * );
 *
 * Usage for image repeater in four column grid:
 * Component::render(
 *    'image-repeater',
 *    'boilerplate',
 *    [
 *        'containerClass' => 'v7-image-grid',
 *        'imageClass' => 'v7-image-grid-item'
 *    ]
 * );
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
    <div class="v7-content <?= esc_attr($containerClass) ?>">
        <?php
        foreach ($images as $image) :
            Component::render(
                'v51/image',
                [
                    'image' => $image['image'] ?? '',
                    'imageRetina' => $image['image_retina'] ?? '',
                    'class' => 'v7-image-grid-item',
                    'class' => $imageClass,
                    'onlyLazyImageClass' => true
                ]
            );
        endforeach;
        ?>
    </div>
</section>
