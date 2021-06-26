<?php
/**
 * Template file. Template params are stored in $params array
 * @param string $title       Dropdown title
 * @param bool   $icon        Should icon be in dropdown title
 * @param array  $options     Associative array of options
 */

if (empty($options) && !is_array($options)) {
    return;
}
?>
<div class="v7-dropdown v7-dropdown-posts-browser v7-mb-40">
    <span class="v7-dropdown-trigger">
        <span class="v7-dropdown-trigger-content"><?= esc_html($title) ?></span>
        <?php if (!empty($icon)) : ?>
            <i class="material-icons">keyboard_arrow_down</i>
        <?php endif; ?>
    </span>
    <ul class="v7-dropdown-list">
    <?php $i = 0;
    foreach ($options as $option) : ?>
        <li
            data-posts-browser="<?= $i ?>"
            class="v7-dropdown-option js-v7-posts-browser-navigation-item"
            <?= $i === 0 ? 'data-state="active"' : '' ?>
        >
            <?= esc_html($option['name']) ?>
        </li>
        <?php $i++;
    endforeach; ?>
    </ul>
</div>
