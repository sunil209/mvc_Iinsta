<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $sectionLabel    Label above all radio inputs
 * @param string $name            Value for 'name' attribute
 * @param array  $radios          An array of radios, each containing:
 *               string value           DOMString containing the radio button's value
 *               string label           Title of radio
 * @param array  $response        Form state
 *
 * @example Usage
 * Component::render(
 *   'input',
 *   'radio,
 *   [
 *     'sectionLabel' => 'Send to',
 *     'name' => 'send-to',
 *     'response' => $response,
 *     'radios' =>
 *     [
 *       [
 *         'value' => 'us',
 *         'label' => 'United States'
 *       ],
 *       [
 *         'value' => 'pl',
 *         'label' => 'Poland'
 *       ]
 *     ]
 *   ]
 * );
 * @endexample
 */
?>

<label class="v7-input-label-title"><?= $sectionLabel ?></label>
<div class="v7-input-radio-wrapper">
    <?php foreach ($radios as $radio) : ?>
        <label class="v7-input-radio">
            <input
                class="v7-input-radio-button js-input-radio"
                type="radio"
                value="<?= esc_attr($radio['value']) ?>"
                name="<?= esc_attr($name) ?>"
                <?= $response['fields'][$name][$radio['value']]; ?>
            >
            <span><?= esc_html($radio['label']) ?></span>
        </label>
    <?php endforeach ?>
</div>

