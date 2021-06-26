<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string sectionTitle          The title of a section
 * @param string sectionSubtitle       The subtitle of a section
 * @param string innerComponent        A variable to decide which component should be inside filter sections
 * @param array  filters               An array of filter sections, each containing:
 *               string name                Name of a section title, to be filtered by
 *               string visibility          Variable to decide which filter section should be visible on entry
 *               array  images              An array of images for filter-images component
 *               array  leftRightSection    An array for inner left-right component
 *
 * @example Basic usage
 * Component::render('filter');
 * @endexample
 */

use \Instapage\Classes\Component;

if (!empty($sectionTitle)) : ?>
    <div class="v7 v7-mt-80 text-center">
    <?php
    Component::dumbRender('division-header', [
        'title' => $sectionTitle,
        'subtitle' => $sectionSubtitle,
        'class' => 'v7-mb-30 v7-mb-md-40'
    ]);
else : ?>
    <div class="v7-pt-sm-60 v7-pt-md-50 text-center">
<?php endif;
foreach ($filters as $filter) : ?>
    <a
        class="js-filter-single v7-link-filter link-cta-big"
        data-category="<?= esc_attr(str_replace(' ', '', $filter['name'])); ?>"
        href="#"
        data-scroll="180"
        data-state="<?= $filter['visiblility'] ?? ''; ?>"
    >
        <?= esc_attr($filter['name']); ?>
    </a>
<?php endforeach; ?>
</div>

<div class="js-filter-group <?= $innerComponent === 'left-right' ? 'v7-filter-group' : '' ?> fade slow-effect">
    <?php foreach ($filters as $filter) : ?>
    <div
        class="
            js-filter-element <?= $innerComponent === 'images' ? 'js-gallery-wrapper v7-group' : '' ?>
            <?= $filter['visiblility'] === 'active' ? '' : 'v7-is-hidden'; ?>
        "
        data-filter="<?= esc_attr(str_replace(' ', '', $filter['name'])); ?>"
    >
        <?php
        if ($innerComponent === 'images') :
            Component::render('filter-images', ['filterImages' => $filter['images']]);
        elseif ($innerComponent === 'left-right') :
            $leftRightSection = $filter['left_right'];
            Component::render(
                'left-right',
                'simplified',
                [
                    'class' => 'js-gallery',
                    'contentClass' => 'v7-left-right-inner-section',
                    'leftRightLayout' => $leftRightSection['layout'],
                    'renderTileUnderImage' => $leftRightSection['tile_under_image'],
                    'leftRightRow' => [
                        'image' => $leftRightSection['image'],
                        'imageRetina' => $leftRightSection['image_retina'],
                        'text' => $leftRightSection['text'],
                    ]
                ]
            );
        endif; ?>
    </div>
    <?php endforeach; ?>
</div>
