<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  filterImages           An array of filter's images, each containing:
 *               array  image            An array of metadata for regular image
 *               array  image_retina     An array of metadata for retina image
 *
 * @example Basic usage inside Filter component
 * Component::render('filter-images', ['filterImages' => $filter['images']]);
 * @endexample
 */

use \Instapage\Helpers\HtmlHelper;

if (empty($filterImages)) {
    return;
}

foreach ($filterImages as $image) : ?>
<a
    class="js-gallery v7-group-item"
    href="<?= esc_url(
        $image['image_retina']['sizes']['listing-size-retina']
        ?? $image['image']['sizes']['large']
    ) ?>"
>
    <img
        class="img-responsive img-rounded v7-group-img"
        src="<?= esc_url($image['image']['sizes']['medium'] ?? '') ?>"
        <?= HtmlHelper::renderSrcSet(
            [
                '1x' => esc_url($image['image']['sizes']['medium'] ?? ''),
                '2x' => esc_url($image['image_retina']['sizes']['medium_large'] ?? '')
            ]
        ); ?>
        alt="<?= esc_attr($image['image']['title']); ?>"
    >
</a>
<?php endforeach; ?>
