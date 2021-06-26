<?php
use \Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Component;

?>

<div class="v7-content v7-header-content">
    <div class="v7-header-copy">
        <?= $headerSlotTop ?>
        <?php if (!empty($featuredIcon)) : ?>
        <div class="v7-mb-30 v7-mx-auto v7-header-icon-container">
            <img
                class="v7-header-icon"
                src="<?= esc_url($featuredIcon); ?>"
                alt="<?= (!empty($title)) ? esc_attr($title) : ''; ?>"
            >
        </div>
        <?php endif; ?>
        <?php if (!empty($label)) : ?>
            <h4 class="v7-header-label v7-mb-10 v7-mb-md-20 <?= $isTextDark ? '' : 'white' ?>">
                <?= esc_html($label) ?>
            </h4>
        <?php endif;
        if (!empty($title)) : ?>
            <h1 class="<?= $isTextDark ? '' : 'white' ?>"><?= wp_kses($title, ['br' => []]) ?></h1>
        <?php endif;
        if (!empty($subtitle)) : ?>
            <p class="<?= $isTextDark ? '' : 'white' ?>"><?= wp_kses($subtitle, ['br' => []]) ?></p>
        <?php endif;
        if (!empty($headerSlot)) : ?>
            <?= $headerSlot ?>
        <?php endif;
        if (!empty($scrollToSelector)) : ?>
            <a href="<?= esc_url($scrollToSelector) ?>" data-scroll="100">
                <i class="material-icons hero-scroll">keyboard_arrow_down</i>
            </a>
        <?php endif;
        if (!empty($buttons)) :
            Component::render('buttons-group', ['buttons' => $buttons]);
        endif;
        ?>
    </div>
    <?php if (!empty($image['url']) && !$isImageBackground) : ?>
        <div class="v7-header-img-wrapper">
        <img
            class="v7-header-img"
            src="<?= esc_url($image['url']) ?>"
            <?= HtmlHelper::renderSrcSet([
                '1x' => esc_url($image['url']),
                '2x' => esc_url($imageRetina['url'])
                ]); ?>
            alt="<?= esc_attr($image['alt']) ?>">
    </div>
    <?php endif; ?>
</div>
