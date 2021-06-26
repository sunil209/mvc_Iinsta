<?php
/**
 * Square tiles with icons, title and link.
 * Template params are stored in $params array
 *
 * @param string  $image             Icon for the panel header.
 * @param string  $title             Title of the tile.
 * @param string  $text              Text paragraph of the tile.
 * @param string  $url               Url for the link to more content.
 * @param string  $moreText          Text for the link to more content (e.g. products).
 * @param string  $gaCategory        Category of event send by event dispatcher elements to Google Analytics
 *
 * @example Default
 *  Component::render('v70/panel-section');
 *
 * @endexample
 *
 */

use \Instapage\Classes\Component;
?>

<div class="v7-flat-box v7-flat-panel <?= esc_attr($class ?? '') ?>"">
<?php if (!empty($url)) : ?>
    <a
        href="<?= esc_url($url) ?>"
        class="v7-flat-panel-copy"
        <?php
        // Please be really careful when editing this component,
        // this can change GA Events (GA Event cannot be deleted or altered)
        Component::render(
            'generic/ga-event-dispatcher',
            [
                'category' => $gaCategory ?? '',
                'label' => $title ?? ''
            ]
        )
        ?>
    >
<?php endif; ?>
        <?php if (!empty($title)) : ?>
        <header class="v7-flat-panel-header v7-mb-20">
            <div class="v7-flat-panel-icon-wrapper">
            <?php Component::render(
                'v51/image',
                [
                    'image' => $image,
                    'onlyLazyImageClass' => true
                ]
            ); ?>
            </div>
            <h3 class="v7-ml-20 v7-flat-panel-title"><?= esc_html($title) ?></h3>
        </header>
        <?php endif; ?>
        <?php if (!empty($text)) : ?>
            <p class="v7-flat-panel-text"><?= esc_html($text) ?></p>
        <?php endif; ?>
        <?php if (!empty($url) && !empty($moreText)) : ?>
            <span class="v7-panel-cta v7-flat-panel-cta v7-btn v7-btn-flat">
                <?= esc_html($moreText) ?>
            </span>
        <?php endif; ?>
    <?php if (!empty($url)) : ?>
    </a>
    <?php endif; ?>
    <?php if ($circleBtn && !empty($url)) : ?>
        <a href="<?= esc_url($url ?? '') ?>" class="v7-flat-panel-circle-btn v7-bg-sky">
            <img
                src="<?= get_template_directory_uri() . '/v5/components/v70/panel/images/arrow.svg' ?>"
                alt="Circle button"
            >
        </a>
    <?php endif; ?>
    </div>
