<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title         Sidebar title
 * @param string $sidebarClass  Sidebar additional classes
 * @param string $sidebarMobile Here is the slot for sidebar mobile version
 * @param array  $options       An array with data to loop over: ['class', 'url', 'name', 'attributes']
 * @param array  $attributes    Associative array of attributes
 */

if (empty($options) || !is_array($options)) {
    return;
}
?>

<div class="v7 v7-sidebar js-sidebar">
    <h2 class="v7-sidebar-title"><?= esc_html($title); ?></h2>
    <ul class="v7-sidebar-menu v7-mt-30 ">
        <?php foreach ($options as $option) : ?>
        <li>
            <a
                class="v7-sidebar-menu-link <?= ($filter ?? false) ? 'js-filter-single' : '' ?>"
                data-scroll="150"
                data-category="<?= esc_attr($option['attributes']['data-category'] ?? '') ?>"
                href="<?= esc_url($option['url'] ?? $option['id']); ?>"
            >
            <?= esc_html($option['name']); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?= $sidebarMobile ?? $sidebarMobile ?>
</div>
