<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $sectionTitle      Division title
 * @param string $sectionSubtitle   Division subtitle
 * @param string $class             Optional section class passed as parameter
 * @param string $benefitsClass     Optional benefits container class passed as parameter
 * @param array  $benefits          An array with data to loop over: ['icon', 'name', 'description']
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;

if (empty($benefits) || !is_array($benefits)) {
    return;
}
?>

<section class="v7 v7-mt-80 <?= esc_attr($class) ?>">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    }
    ?>
    <div class="
        v7-content v7-benefits-inline-wrapper
        <?= esc_attr($benefitsClass) ?>
    ">
        <?php
        foreach ($benefits as $benefit) : ?>
            <div class="v7-benefits-inline v7-mx-md-auto">
                <?php if (!empty($benefit['icon'])) : ?>
                <div class="v7-benefits-inline-icon-wrapper">
                    <div class="v7-benefits-inline-icon">
                        <img
                            class="lazyload"
                            data-src="<?= $benefit['icon']; ?>"
                            <?php if ($benefit['icon_retina']) : ?>
                                <?= HtmlHelper::renderSrcSet(
                                    [
                                    '1x' => $benefit['icon'],
                                    '2x' => $benefit['icon_retina']
                                    ],
                                    'data-srcset'
                                ); ?>
                            <?php endif; ?>
                            alt="<?= esc_attr($benefit['name']); ?>"
                        >
                    </div>
                    <?php if (!empty($benefit['name'])) : ?>
                        <h4 class="v7-benefits-inline-heading v7-heading-large v7-is-hidden-lg">
                            <?= esc_html($benefit['name']); ?>
                        </h4>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="v7-benefits-copy-inline">
                    <?php if (!empty($benefit['name'])) : ?>
                        <h4 class="v7-heading-large v7-mt-20 v7-is-hidden-lg-up">
                            <?= esc_html($benefit['name']); ?>
                        </h4>
                    <?php endif; ?>
                    <?php if (!empty($benefit['description'])) : ?>
                        <p><?= esc_html($benefit['description']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
