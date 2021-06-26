<?php
/**
 * Template file. Template params are stored in $params array
 */

use Instapage\Classes\Component;
use Instapage\Helpers\HtmlHelper;

if (empty($repeater)) {
    return;
}
?>
<section class="v7 v7-mt-80 v7-feature-no-button">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    } ?>

    <div class="v7-feature-repeater-container <?= esc_attr($repeaterLayout) ?> v7-content" data-self="sm-only-full">
    <?php foreach ($repeater as $feature) : ?>
        <?php if (!empty($feature['url'])) : ?>
        <a
            href="<?= esc_url($feature['url']) ?>"
            class="v7-box v7-box-clickable v7-feature-container v7-feature"
        >
        <?php else : ?>
        <div class="v7-box v7-feature-container v7-feature">
        <?php endif ?>
            <div class="v7-feature-image">
                <img src="<?= esc_url($feature['icon']) ?>" alt="<?= esc_attr($feature['title']) ?>" />
            </div>
            <div class="v7-feature-copy">
                <div class="v7-feature-copy-text">
                    <h4><?= esc_html($feature['title']) ?></h4>
                    <?php if (!empty($feature['subtitle'])) {
                        echo HtmlHelper::setParagraph($feature['subtitle']);
                    } ?>
                </div>
            </div>
        <?php if (!empty($feature['url'])) : ?>
            <span class="v7-feature-index-follow-link v7-btn v7-btn-flat">
                <?php if ($repeaterLayout === 'v7-feature-repeater-container-row') : ?>
                    <span class="sm-visible"><?= esc_html($feature['url_text']) ?></span>
                    <i class="v7-follow-icon material-icons md-visible">chevron_right</i>
                <?php else : ?>
                    <span><?= esc_html($feature['url_text']) ?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php else : ?>
        </div>
        <?php endif ?>
    <?php endforeach; ?>
    </div>
</section>
