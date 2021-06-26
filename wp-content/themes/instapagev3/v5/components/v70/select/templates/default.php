<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title       Select title
 * @param string $selectClass Select container class
 * @param array  $options     An array with data to loop over: ['id', 'url', 'name', 'attributes']
 */

if (empty($options) || !is_array($options)) {
    return;
}
?>

<div class="select-container <?= $selectClass ?? $selectClass ?>">
    <select
    class="select js-select <?= ($filter ?? false) ? 'js-filter-select' : '' ?>"
    name="<?= esc_attr($name); ?>"
    data-placeholder="<?= esc_attr($title); ?>">
    <option value=""></option>
        <?php foreach ($options as $option) : ?>
            <option
            value="<?= esc_attr($option['name']); ?>"
            data-href="<?= esc_url($option['url'] ?? $option['id']); ?>"
            data-category="<?= esc_attr($option['attributes']['data-category'] ?? '') ?>"
            class="<?= ($filter ?? false) ? 'js-filter-single' : '' ?>"
            >
            <?= esc_html($option['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
