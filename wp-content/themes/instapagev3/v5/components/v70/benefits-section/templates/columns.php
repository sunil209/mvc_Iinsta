<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $benefits
 *               string icon   URL for icon
 *               string name
 *               string description
 *
 */
use Instapage\Classes\Component;

if (empty($benefits) || !is_array($benefits)) {
    return;
}

?>

<section class="v7 text-center <?= esc_attr($sectionClass ?? ''); ?>">
    <div class="container <?= esc_attr($containerClass ?? ''); ?>">
        <div class="row">
            <?php foreach ($benefits as $benefit) : ?>
                <div class="v7-benefits-columns v7-mb-30 v7-mb-md-20 col-12 col-sm-8 offset-sm-2 col-md-4 offset-md-0">
                    <?php if (!empty($benefit['icon'])) : ?>
                        <div class="v7-benefits-icon">
                            <img
                                class="v7-img-responsive-xy v7-mx-auto"
                                src="<?= esc_url($benefit['icon'] ?? ''); ?>"
                                alt="<?= esc_attr($benefit['name'] ?? ''); ?>"
                            >
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($benefit['name'])) : ?>
                        <h5 class=" v7-heading-large v7-pt-md-20"><?= esc_html($benefit['name'] ?? ''); ?></h5>
                    <?php endif;?>
                    <?php if (!empty($benefit['description'])) : ?>
                        <p class="small"><?= esc_html($benefit['description'] ?? ''); ?></p>
                    <?php endif;?>
                </div>
            <?php endforeach ?>
        </div>
    </div>

</section>

