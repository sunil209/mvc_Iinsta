<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $sectionTitle         Title over logos.
 * @param string $sectionSubtitle      Subtitle over logos.
 * @param array  $items      An array with data to loop over: ['image', 'imageRetina', 'alt']
 *
 * @example Basic ACF example
 * Component::render('logos');
 * @endexample
 *
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;

if (empty($items) || !is_array($items)) {
    return;
}

?>
<?php if (!empty($sectionTitle)) : ?>
    <section class="v7 v7-logo <?= esc_attr($sectionClass ?? 'v7-mt-80') ?>">
    <?php
    Component::dumbRender('division-header', [
        'title' => $sectionTitle,
        'subtitle' => $sectionSubtitle,
        'class' => 'v7-mb-40 v7-mb-md-50'
    ]);
else : ?>
    <section
        class="v7-logo
        <?= esc_attr($logosClass ? $logosClass : '') ?>
        <?= esc_attr($logosSpacing ?? 'v7-pt-sm-60 v7-pt-md-50') ?>"
    >
<?php endif; ?>
    <div class="v7-content v7-logo-bar">
        <?php
        foreach ($items as $item) :
            if (isset($item['image']) && !empty($item['image'])) :
                $images = (isset($item['imageRetina']) && !empty($item['imageRetina']))
                    ? ['1x' => $item['image'], '2x' => $item['imageRetina']]
                    : ['1x' => $item['image']];
                ?>
                <img
                    class="v7-logo-image lazyload"
                    data-src="<?= esc_url($item['image']); ?>" <?= HtmlHelper::renderSrcSet($images); ?>
                    alt="<?= (isset($item['alt'])) ? esc_attr($item['alt']) : ''; ?>"
                >
            <?php endif;
        endforeach;?>
    </div>
</section>
