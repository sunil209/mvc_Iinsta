<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $item                  One accordion item containing:
 *               string title           Title of accordion
 *               string icon            Url for icon in accordion title
 *
 * @example Usage
 * Component::render('accordion-header', ['item' => $item]);
 * @endexample
 */

if (empty($item) && !is_array($item)) {
    return;
}
?>

<div class="v7-accordion-header js-expand-accordion">
<?php if (!empty($item['icon'])) : ?>
    <img 
        class="v7-accordion-header-img"
        src="<?= esc_url($item['icon']) ?>"
        alt="<?= esc_attr($item['title'] ?? '') ?>"
    >
<?php endif; ?>
    <h3 class="v7-accordion-header-title"><?= esc_html($item['title'] ?? '') ?></h3>
    <img 
        class="v7-accordion-icon"
        src="<?= WP_CONTENT_URL ?>/themes/instapagev3/v5/assets/images/arrow-down.svg" 
    />
</div>
