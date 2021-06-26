<?php
/**
 * Template params are stored in $params array
 *
 * @param array  $templates   Array of templates from the app, including e.g.:
 *        @param string $slug             Slug to single page within that post type
 *        @param string $name             Name of the template
 *        @param string $website_image    Url the image of a topfold
 *        @param string $image            Url the image of a topfold in better quality
 *        @param string $class            Class for filtering by category
 *        @param bool   $showListing      Boolean that determins showing template in this component
 *        @param bool   $showListing      Boolean that determins overlay
 *
 * @example Default
 *  Component::render('thumbnails', ['templates' => $templates]);
 *
 * @endexample
 *
 */

use \Instapage\Helpers\HtmlHelper;

if (empty($templates) && !is_array($templates)) {
    return;
}
?>
<section class="v7-thumbnails-group text-center js-filter-group fade slow-effect" id="top">
    <?php foreach ($templates as $template) : ?>
        <?php if (!$template->showInListing) {
            continue;
        } ?>
        <a
            class="v7-box v7-box-clickable v7-thumbnail js-filter-element"
            href="<?= esc_url(home_url($template->slug) ?? ''); ?>"
            data-filter="<?= $template->class ?? ''; ?>"
        >
            <img class="img-fullwidth lazyload"
                src="<?= esc_url($template->thumbnail_image); ?>"
                srcset="<?= getImagePlaceholder('templates'); ?> 1x"
                <?= HtmlHelper::renderSrcSet(
                    [
                        '1x' => $template->thumbnail_image ?? '',
                        '2x' => $template->thumbnail_image_retina ?? '',
                    ],
                    'data-srcset'
                ); ?>
                data-sizes="auto"
                alt="<?= esc_attr($template->name ?? ''); ?>"
            />
            <?php if ($template->showDetailed) : ?>
            <div class="v7-thumbnail-link v7-btn-flat"><?= __('VIEW LAYOUT &#10132;'); ?></div>
            <?php endif; ?>
        </a>
    <?php endforeach; ?>
</section>
