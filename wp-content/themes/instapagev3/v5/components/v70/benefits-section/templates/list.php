<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title      Division title
 * @param array  $benefits
 *                        string icon   URL for icon
 *                        string name   Benefit name
 *
 */
use Instapage\Classes\Component;

if (empty($benefits) || !is_array($benefits)) {
    return;
}

?>

<section class="v7 v7-mt-80">
    <header class="v7-content-md text-center v7-mb-40 v7-mb-md-50">
        <?php if (!empty($sectionTitle)) : ?>
            <h2 class="v7-heading-xxxlarge"><?= esc_html($sectionTitle) ?></h2>
        <?php endif;?>
        <?php if (!empty($sectionSubtitle)) : ?>
            <p><?= esc_html($sectionSubtitle) ?></p>
        <?php endif;?>
    </header>
    <div class="v7-benefits-containter v7-content v7-benefits-list">
        <?php foreach ($benefits as $benefit) : ?>
            <div class="v7-benefits">
                <?php if (!empty($benefit['icon'])) : ?>
                    <div class="v7-benefits-icon">
                        <img
                            class="v7-benefits-icon-img"
                            src="<?= esc_url($benefit['icon']) ?>"
                            alt="<?= esc_attr($benefit['name']) ?>"
                        >
                    </div>
                <?php endif; ?>
                <?php if (!empty($benefit['name'])) : ?>
                    <h5><?= esc_html($benefit['name']) ?></h5>
                <?php endif;?>
            </div>
        <?php endforeach ?>
    </div>
</section>

