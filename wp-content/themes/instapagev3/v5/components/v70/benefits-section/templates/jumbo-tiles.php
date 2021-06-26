<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $sectionTitle      Division title
 * @param string $sectionSubtitle   Division subtitle
 * @param string $class             Optional section class passed as parameter
 * @param string $benefitsClass     Optional benefits container class passed as parameter
 * @param string $layout            Layout type selected from ACF
 * @param array  $benefits          An array with data to loop over: ['icon', 'name', 'description']
 */

if (empty($benefits) || !is_array($benefits)) {
    return;
}
?>

<section class="v7 v7-content v7-benefits-jumbo-tiles-container <?= esc_attr($benefitsClass) ?>">
    <?php
    foreach ($benefits as $benefit) : ?>
        <a
            href="<?= esc_url($benefit['url']) ?>"
            class="v7-benefits-jumbo-tile v7-box v7-box-vertical v7-box-clickable"
        >
            <div class="v7-benefits-jumbo-tile-header">
            <?php if (!empty($benefit['icon']) && !empty($benefit['name'])) : ?>
                <img
                    class="v7-mr-20 v7-mr-md-30 v7-benefits-jumbo-tile-icon"
                    src="<?= esc_url($benefit['icon']); ?>"
                    alt="<?= esc_attr($benefit['name']); ?>"
                >
            <?php endif;
            if (!empty($benefit['name'])) : ?>
                <h4 class="v7-benefits-jumbo-tile-title"><?= esc_html($benefit['name']); ?></h4>
            <?php endif;?>
            </div>
            <?php if (!empty($benefit['description'])) : ?>
                <p class="v7-mb-30 v7-mb-lg-20 v7-benefits-jumbo-tile-copy">
                    <?= esc_html($benefit['description']); ?>
                </p>
            <?php endif; ?>
            <img
                class="v7-benefits-jumbo-tile-link v7-benefits-jumbo-tile-link-animation"
                src="<?= get_template_directory_uri() . '/v5/components/v70/benefits-section/images/icon-arrow.svg' ?>"
                alt="Arrow icon"
            >
        </a>
    <?php endforeach; ?>
</section>
