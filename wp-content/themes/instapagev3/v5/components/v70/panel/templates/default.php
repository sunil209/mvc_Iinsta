<?php
/**
 * Square tiles with icons, title and link.
 * Template params are stored in $params array
 *
 * @param string  $image             Image.
 * @param string  $imageRetina       Retina image.
 * @param string  $title             Title of the tile.
 * @param string  $text              Text paragraph of the tile.
 * @param string  $url               Url for the link to more content.
 * @param string  $moreText          Text for the link to more content (e.g. products).
 * @param string  $label             Post type used in a tile.
 *
 * @example Default
 *  Component::render('v70/panel-section');
 *
 * @endexample
 *
 */

use \Instapage\Classes\Component;

$panelHeading;
if (!empty($url)) {
    $panelHeading = '<a href="' . esc_url($url) . '" class="v7-btn-flat-black">' . esc_html($title) . '</a>';
} else {
    $panelHeading = esc_html($title);
}
?>

<div class="v7-box v7-box-vertical <?= !empty($url) ? 'v7-box-clickable' : ''; ?> v7-panel-layout">
    <?php if (!empty($url)) : ?>
        <a
            href="<?= esc_url($url); ?>"
            class="<?= $layout === 'logo' ? 'v7-panel-logo-link' : 'v7-panel-image-link'; ?>"
        >
    <?php endif; ?>
        <?php
        Component::render(
            'v51/lazy-image',
            [
                'imageClass' => 'v7-panel-image',
                'imageRegularURL' => $image['url'],
                'imageRetinaURL' => $image_retina['url'],
                'width' => $image['width'],
                'height' => $image['height'],
                'alt' => $title,
                'constrainMaxWidth' => true
            ]
        );
        ?>
    <?php if (!empty($url)) : ?>
        </a>
    <?php endif; ?>
    <div class="v7-box-copy v7-panel-copy <?= empty($url) ? 'v7-panel-copy-short' : 'v7-panel-copy-long' ?>">
        <?php if (!empty($label)) : ?>
        <div>
            <span class="v7-panel-label v7-pb-10"><?= $label; ?></span>
        <?php endif; ?>
        <?php if (!empty($layout) && $layout === 'double') : ?>
            <h2 class="v7-panel-title"><?= $panelHeading; ?></h2>
        <?php elseif (!empty($layout) && $layout === 'bigHeading') : ?>
            <h3 class="h1"><?= $panelHeading; ?></h3>
        <?php else : ?>
            <h4 class="v7-panel-title"><?= $panelHeading; ?></h4>
        <?php endif; ?>
        <?php if (!empty($label)) : ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($text)) : ?>
            <p class="v7-panel-text"><?= esc_html($text); ?></p>
        <?php endif; ?>
        <?php if (!empty($url) && !empty($moreText)) :
            $class = !empty($label) ? 'v7-panel-label-cta' : '';
            Component::render('button', [
                'url' => $url,
                'class' => $class .' v7-panel-cta v7-btn v7-btn-flat',
                'text' => $moreText
            ]);
            ?>
        <?php endif; ?>
    </div>
</div>