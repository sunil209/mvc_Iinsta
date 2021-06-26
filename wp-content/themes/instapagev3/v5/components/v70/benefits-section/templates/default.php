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
        v7-content v7-benefits-containter
        <?= $layout === 'no_tiles' ? 'v7-benefits-no-tiles' : 'v7-benefits-tiles'; ?>
        <?= count($benefits) === 2 ? 'v7-benefits-double' : ''; ?>
        <?= esc_attr($benefitsClass) ?>
    ">
        <?php foreach ($benefits as $benefit) :
            if (!empty($benefit['icon'])) : ?>
            <div class="v7-mb-40 v7-mx-md-auto v7-benefits">
                <?php if ($layout === 'no_tiles_small') : ?>
                    <div class="v7-benefits-icon no-margin-bottom is-centered">
                        <img src="<?= esc_url($benefit['icon']); ?>" alt="<?= esc_attr($benefit['name']); ?>">
                    </div>
                <?php elseif ($layout === 'tiles') : ?>
                    <div class="v7-box v7-box-vertical v7-benefits-icon">
                        <img src="<?= esc_url($benefit['icon']); ?>" alt="<?= esc_attr($benefit['name']); ?>">
                    </div>
                <?php else : ?>
                <div class="v7-benefits-icon">
                    <img
                        class="lazyload v7-benefits-icon-img"
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
                <?php endif; ?>
                <div class="v7-benefits-copy text-center">
                    <?php if (!empty($benefit['name'])) : ?>
                        <h4><?= wp_kses($benefit['name'], ['br' => []]); ?></h4>
                    <?php endif;
                    if (!empty($benefit['description'])) : ?>
                        <p><?= esc_html($benefit['description']); ?></p>
                    <?php endif;
                    if (!empty($benefit['link']) && !empty($benefit['url'])) : ?>
                        <a class="v7-mt-20 v7-btn v7-btn-flat" href="<?= esc_url($benefit['url']); ?>" target="_blank">
                            <?= esc_html($benefit['link']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif;
        endforeach; ?>
    </div>
</section>
