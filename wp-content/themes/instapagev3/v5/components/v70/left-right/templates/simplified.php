<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string class                 Additional class for styling or function, e.g. 'js-gallery' when inside Filter
 * @param string contentClass          Additional class for styling inside v7-left-right-text
 * @param bool   leftRightLayout       Starting from right or left side
 * @param bool   renderTileUnderImage  Should a tile be rendered under the section image
 * @param array  leftRightRow          An array of sections, each containing:
 *               array  image               Image of a subsection with all metadata
 *               array  imageRetina         Retina image of a subsection with all metadata
 *               string text                Content of the section
 *
 * @example Basic usage inside Filter component
 * Component::render(
 *     'left-right',
 *     'simplified',
 *     [
 *         'class' => 'js-gallery',
 *         'leftRightLayout' => $leftRightSection['layout'],
 *         'renderTileUnderImage' => $leftRightSection['tile_under_image'],
 *         'leftRightRow' => [
 *             'image' => $leftRightSection['image'],
 *             'imageRetina' => $leftRightSection['image_retina'],
 *             'text' => $leftRightSection['text'],
 *         ]
 *     ]
 * );
 * @endexample
 */

use \Instapage\Classes\Component;
?>

<div class="v7-content">
    <div
        class="
            v7 v7-mt-40 v7-mt-md-50 v7-left-right-section v7-left-right-simplified
            <?= $leftRightLayout ? 'v7-left-right-odd' : '' ?>
            <?= $renderTileUnderImage ? 'v7-left-right-section-image-tiles' : '' ?>
            <?= $class ?? '' ?>
        "
    >
    <?php
    if (!empty($leftRightRow['image']['url'])) :
        ?>
        <div
            class="
                v7-position-relative v7-left-right-img-section
                <?=
                    'v7-left-right-img-section'
                    . ($renderTileUnderImage ? '-tiles' : '-regular')
                ?>
            "
        >
            <div class="<?= 'v7-left-right-img' . ($renderTileUnderImage ? '-with-tile-container' : '') ?>">
                <?php
                    Component::render('v51/lazy-image', [
                        'imageRegularURL' => $leftRightRow['image']['url'],
                        'imageRetinaURL' => $leftRightRow['image_retina']['url'],
                        'width' => $leftRightRow['image']['width'],
                        'height' => $leftRightRow['image']['height'],
                        'alt' => $leftRightRow['image']['title'],
                        'imageClass' => $renderTileUnderImage ? '' : 'insta-lazy-image-object-fit-contain-large-tablet'
                    ]);
                ?>
            </div>
        </div>
    <?php endif ?>
        <div class="v7-left-right-text-section">
            <div class="v7-left-right-text v7-left-right-text-right <?= $contentClass ?>">
            <?php if (!empty($leftRightRow['text'])) : ?>
                <?= $leftRightRow['text']; ?>
            <?php endif ?>
            </div>
        </div>
    </div>
</div>
