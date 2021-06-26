<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string    $text       Text to be displayed on button
 * @param string    $type       Type of button, default value is 'submit'
 * @param string    $class      Button classes
 *
 *
 * @example Advanced usage
 * Component::render('button', 'with-loading-state', [
 *      'text' => __('REQUEST DEMO'),
 *      'class' => 'v7-mt-40'
 * ]);
 * @endexample
 */

if (empty($text)) {
    return;
}

// default component param values
$type = $type ?? 'submit';

?>

<div class="v7-btn-with-loading-state-wrapper js-btn-with-loading-state-wrapper  <?= esc_attr($class ?? '') ?>">
    <button
        type="<?= esc_attr($type) ?>"
        class="v7-btn v7-btn-cta v7-btn-submit fx-ripple-effect v7-btn-with-loading-state"
    >
        <?= esc_html($text) ?>
    </button>
</div>
