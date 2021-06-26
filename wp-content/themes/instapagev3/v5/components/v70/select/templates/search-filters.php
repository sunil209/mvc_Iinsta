<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title       Select title
 * @param string $selectClass Select container class
 * @param array  $options     An array with data to loop over: ['id', 'url', 'name', 'attributes']
 */

if (empty($categories) || !is_array($categories) || empty($tags) || !is_array($tags)) {
    return;
}
?>

<div class="v7-select-search-filters row no-gutters">
    <div class="select-container col-12 col-md-auto col-lg-4">
        <select
            class="select js-select js-search-filter-category-select js-filter-select"
            name="<?= esc_attr($categoriesName); ?>"
            data-placeholder="<?= esc_attr($categoriesTitle); ?>"
        >
        <option value=""></option>
            <?php foreach ($categories as $category) : ?>
                <option
                    value="<?= esc_attr($category['name'] ?? ''); ?>"
                    data-category="<?= esc_attr($category['id'] ?? '') ?>"
                    class="js-search-filter-category"
                >
                <?= esc_html($category['name'] ?? ''); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="select-container col-12 col-md-auto col-lg-4">
        <select
            class="select js-select js-search-filter-tag-select js-filter-select"
            name="<?= esc_attr($tagsName ?? ''); ?>"
            data-placeholder="<?= esc_attr($tagsTitle ?? ''); ?>"
        >
        <option value=""></option>
            <?php foreach ($tags as $tag) : ?>
                <option
                    value="<?= esc_attr($tag['name'] ?? ''); ?>"
                    data-tag="<?= esc_attr($tag['value'] ?? '') ?>"
                    data-category="<?= esc_attr($tag['value'] ?? '') ?>"
                    class="js-search-filter-tag"
                >
                <?= esc_html($tag['name'] ?? ''); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
