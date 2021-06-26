<?php
/**
 * Generic, version independent component for dispatching click events to Google Analytics
 * Template params are stored in $params array.
 *
 * @param string $category Google Analytics Event Category - required
 * @param string $action   Google Analytics Event Action
 * @param string $label    Google Analytics Event Label - required
 */

if (empty($category) || empty($label)) {
    return;
}

?>
data-ga-category="<?= esc_attr($category ?? '') ?>"
data-ga-action="<?= esc_attr($action ?? 'click') ?>"
data-ga-label="<?= esc_attr($label ?? '') ?>"
