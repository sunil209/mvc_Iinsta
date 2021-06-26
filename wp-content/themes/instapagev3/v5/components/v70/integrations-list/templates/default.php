<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $integrationsCategories    An array of integrations' categories, each containing:
 *                   string $groupID            ID of the integrations' category
 *                   string headline            Category's name
 *                   array  $items              An array of integrations, each containing:
 *                       array attributes           attributes of integration
 *                       string title               name of integration
 *                       string icon                url for icon in integration name
 *                       string excerpt             integration summary
 *                       string tag                 tags specifying integration type
 *
 * @example Usage
 * Component::render('integrations-list', ['integrationsCategories' => $integrationsCategories]);
 * @endexample
 */
use Instapage\Helpers\HtmlHelper;

if (empty($integrationsCategories) || !is_array($integrationsCategories)) {
    return;
}
?>

<section class="v7 container v7-integrations-group js-search-content v7-mb-30 v7-mb-lg-50">

<?php foreach ($integrationsCategories as $integrationsCategory) :
    echo '<div
        id="' . (esc_attr($integrationsCategory['groupID']) ?? '') .
        '" class="v7-mt-60 v7-integration-category">';
    if (!empty($integrationsCategory['headline'])) {
        echo '<h2 class="v7-pb-30 v7-pb-md-40 text-center v7-integrations-category-headline">' .
            esc_html($integrationsCategory['headline'] ?? '') .
            '</h2>';
    } ?>
        <div class="row no-gutters-lg v7-integrations-group-wrapper js-filter-group grid-filter-group">
        <div class="category_loader"></div>
        <?php foreach ($integrationsCategory['items'] as $item) : ?>
            <div
                class="col-12 col-lg-4 col-xl-3 v7-integration js-search-element js-filter-element js-single-element"
                data-search="<?= esc_attr($item['title'] ?? '') ?>"
                data-filter="<?php
                foreach ($item['tags'] as $key) {
                    echo $key['value'] . ' ';
                }
                echo $integrationsCategory['groupID'] ?? '';
                ?>"
                <?= HtmlHelper::renderAttributes($item['attributes'] ?? '') ?>
            >
                <?php if (!empty($item['icon'])) : ?>
                    <img
                        class="v7-integration-icon lazyload"
                        src="<?= esc_url($item['icon']) ?>"
                        alt="<?= esc_attr($item['title'] ?? '') ?>"
                    >
                <?php endif; ?>
                <div class="v7-integration-copy">
                    <h3 class="v7-integration-title v7-heading-small"><?= esc_html($item['title'] ?? '') ?></h3>
                    <span class="v7-mt-10 v7-tag"><?= esc_html($item['tags'][0]['label'] ?? '') ?></span>
                </div>
                <div class="v7-integration-description">
                    <div class="row no-gutters v7-integration-description-header">
                    <?php if (!empty($item['icon'])) : ?>
                        <img
                        class="col-auto v7-integration-description-icon"
                        src="<?= esc_url($item['icon']) ?>"
                        alt="<?= esc_attr($item['title'] ?? '') ?>"
                        >
                    <?php endif; ?>
                        <div class="col">
                        <?php if (!empty($item['tags'])) : ?>
                            <span class="v7-tag"><?= esc_html($item['tags'][0]['label']) ?></span>
                        <?php endif; ?>
                            <h5 class="v7-integration-title v7-heading-small"><?= esc_html($item['title'] ?? '') ?></h5>
                        </div>
                    </div>
                    <p class="v7-integration-description-copy v7-heading-basic">
                        <?= esc_html($item['excerpt'] ?? '') ?>
                    </p>
                </div>
            </div>
            <?php
        endforeach;
        echo '</div>';
        echo '</div>';
endforeach; ?>
</section>
