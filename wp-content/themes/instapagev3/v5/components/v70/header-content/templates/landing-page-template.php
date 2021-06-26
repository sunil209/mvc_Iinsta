<?php
use \Instapage\Classes\Component;
?>

<div class="v7-content v7-header-content v7-header-landing-page-template">
    <a
        class="v7-btn v7-btn-round v7-btn-round-ghost v7-header-arrows lg-tb-hidden"
        href="<?= esc_url($prevTemplate); ?>"
    >
        <svg class="v7-header-arrows-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
            <path fill="none" d="M0 0h24v24H0V0z"/>
        </svg>
    </a>
    <div class="v7-header-copy v7-header-copy-narrow">
        <?php if (!empty($label)) : ?>
            <a href="<?= esc_url($labelUrl) ?>">
                <span class="v7-header-label-white v7-mb-10 v7-mb-md-20 white">
                    <?= esc_html($label) ?>
                </span>
            </a>
        <?php endif;
        if (!empty($title)) : ?>
            <h1 class="white"><?= wp_kses($title, ['br' => []]) ?></h1>
        <?php endif;
        if (!empty($subtitle)) : ?>
            <p class="white"><?= wp_kses($subtitle, ['br' => []]) ?></p>
        <?php endif;
        if (!empty($buttonUrl)) :
            Component::render(
                'button',
                [
                    'url' => $buttonUrl,
                    'text' => $buttonText,
                    'class' => 'v7-btn-white v7-mt-40'
                ]
            );
        endif;
        ?>
    </div>
    <a
        class="v7-btn v7-btn-round v7-btn-round-ghost v7-header-arrows lg-tb-hidden"
        href="<?= esc_url($nextTemplate); ?>"
    >
        <svg class="v7-header-arrows-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
            <path fill="none" d="M0 0h24v24H0V0z"/>
        </svg>
    </a>
</div>
