<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $items      An array with data to loop over: ['image', 'imageRetina', 'alt']
 *
 * @example Basic ACF example
 * Component::render('logos', 'grid');
 * @endexample
 *
 */

use Instapage\Helpers\HtmlHelper;

if (empty($items) || !is_array($items)) {
    return;
}

?>

<div class="
    v7 v7-grid-logo-wrapper
    <?= esc_attr($logosSpacing ?? 'v7-pt-sm-60 v7-pt-md-50') ?>
    v7-grid-topfold-helper row no-gutters
">
    <?php
    foreach ($items as $item) :
        if (isset($item['image']) && !empty($item['image'])) :
            $images = (isset($item['imageRetina']) && !empty($item['imageRetina']))
                ? ['1x' => $item['image'], '2x' => $item['imageRetina']]
                : ['1x' => $item['image']];
            ?>
            <div class="v7-mb-30 v7-grid-logo col-6 col-md-auto">
                <img
                    class="lazyload"
                    data-src="<?= esc_url($item['image']); ?>" <?= HtmlHelper::renderSrcSet($images); ?>
                    alt="<?= esc_attr($item['alt'] ?? ''); ?>"
                >
            </div>
        <?php endif;
    endforeach;?>
</div>
