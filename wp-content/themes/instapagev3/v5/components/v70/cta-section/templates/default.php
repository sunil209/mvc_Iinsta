<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title          CTA section title
 * @param string $subtitle       CTA section subtitle
 */

use Instapage\Classes\Component;

if (empty($title)) {
    return;
}
?>

<section class="v7 <?= $isMarginOmitted ? '' : 'v7-mt-80' ?>">
    <div
        class="
            v7-cta
            <?= $backgroundLight ? 'v7-cta-light' : '' ?>
            <?= $backgroundGradientLight ? 'v7-cta-gradient-light' : '' ?>
            <?= $backgroundBrightBlue ? 'v7-cta-bright-blue' : '' ?>
        "
    >
        <div class="v7-content is-narrow text-center">
            <h2 class="h1 <?= !$backgroundLight ? 'white' : '' ?>">
                <?= esc_html($title) ?>
            </h2>
            <p class="<?= !$backgroundLight ? 'white' : '' ?>">
                <?= esc_html($subtitle) ?>
            </p>
        </div>
        <?php Component::render('buttons-group', ['buttons' => $buttons]) ?>
        <?php if (isset($subtitleBottom) && !empty($subtitleBottom)): ?>
        <div class="v7-content is-narrow text-center">
            <div class="white v7-mt-20"><?= $subtitleBottom; ?></div>
        </div>
        <?php endif; ?>
    </div>
</section>
