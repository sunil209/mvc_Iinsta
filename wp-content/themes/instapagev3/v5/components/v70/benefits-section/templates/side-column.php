<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $sectionTitle      Division title
 * @param string $sectionSubtitle   Division subtitle
 * @param array  $benefits          An array with data to loop over: ['icon', 'name', 'description']
 */

use Instapage\Helpers\HtmlHelper;

if (empty($benefits) || !is_array($benefits)) {
    return;
}
?>

<div class="v7 v7-benefits-side-column-wrapper v7-mx-auto <?= $gridClasses ?? '' ?>">
    <div class="v7-mb-40 v7-mx-auto text-center-sm-only">
        <?php if (!empty($sectionTitle)) : ?>
            <h2 class="h1"><?= esc_html($sectionTitle) ?></h2>
        <?php endif;
        if (!empty($sectionSubtitle)) :
            echo HtmlHelper::setParagraph($sectionSubtitle);
        endif; ?>
    </div>
    <?php foreach ($benefits as $benefit) : ?>
        <div class="v7-benefits-inline v7-benefits-side-column">
            <?php if (!empty($benefit['icon'])) : ?>
            <div class="v7-benefits-inline-icon-wrapper v7-benefits-side-column-icon-wrapper">
                <div class="v7-benefits-inline-icon v7-benefits-side-column-icon">
                    <img
                        class="lazyload v7-img-fullwidth-sm-only"
                        data-src="<?= $benefit['icon'] ?>"
                        <?php if (isset($benefit['icon_retina'])) : ?>
                            <?= HtmlHelper::renderSrcSet(
                                [
                                    '1x' => $benefit['icon'],
                                    '2x' => $benefit['icon_retina']
                                ],
                                'data-srcset'
                            ); ?>
                        <?php endif; ?>
                        alt="<?= esc_attr($benefit['name'] ?? 'icon') ?>"
                    >
                </div>
                <?php if (!empty($benefit['name'])) : ?>
                    <h4 class="v7-benefits-inline-heading v7-benefits-side-column-heading v7-heading-large-md-xlarge">
                        <?= esc_html($benefit['name']) ?>
                    </h4>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($benefit['description'])) : ?>
                <p class="v7-mt-10"><?= wp_kses($benefit['description'], ['a' => ['href' => [], 'class' => []]]) ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
