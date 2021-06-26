<?php
/**
 * Template file. Template params are stored in $params array
 * @param string $dropdownClass        - optional class for top element
 * @param bool   $isThumbnailsDropdown - defines if it's used as thumbnails browser navigation
 * @param string $title                - dropdown title
 * @param bool   $icon                 - defines icon in dropdown title
 * @param array  $options              - associative array of options
 */

use \Instapage\Helpers\HtmlHelper;

if (empty($options) && !is_array($options)) {
    return;
}
?>
<div class="v7-dropdown v7-dropdown-listing <?= esc_attr($dropdownClass) ?>">
    <span class="v7-dropdown-trigger">
        <?php if ($isThumbnailsDropdown) : ?>
            <span class="v7-dropdown-trigger-content"><?= esc_html($title) ?></span>
        <?php else : ?>
            <?= esc_html($title) ?>
        <?php endif; ?>
        <?php if (!empty($icon)) : ?>
            <i class="material-icons">keyboard_arrow_down</i>
        <?php endif; ?>
    </span>
    <div class="v7-dropdown-list">
        <?php foreach ($options as $option) : ?>
            <a
                class="v7-dropdown-option <?= esc_attr($option['class'] ?? ''); ?>"
                <?= HtmlHelper::renderAttributes($option['attributes'] ?? ''); ?>
                href="<?= esc_url($option['url'] ?? $option['id'] ?? '') ?>"
            >
                <?= esc_html($option['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
