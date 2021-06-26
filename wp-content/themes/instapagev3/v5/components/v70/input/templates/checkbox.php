<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $name            Name of input element
 * @param string $requiredMessage Text to be displayed as message if input has empty value and is required
 * @param bool   $required        Decide if input element is required
 * @param bool   $checked         Is checkbox checked
 *
 * @example Usage
 * Component::render(
 *   'input',
 *   'checkbox,
 *   [
 *     'name' => 'policy-agreement',
 *     'requiredMessage' => 'You have to agree with our privacy policy',
 *     'required' => true,
 *     'checked' => $response['fields']['policy-agreement'] === 'checked'
 *   ]
 * );
 * @endexample
 */

?>

<div class="v7-checkbox-container <?= esc_attr($sectionClass); ?>" id="<?= esc_attr($id); ?>">
    <label class="v7-checkbox-label">
        <input
            type="checkbox"
            value="1"
            name="<?= esc_attr($name) ?? ''; ?>"
            data-required-message="<?= esc_attr($requiredMessage) ?? ''; ?>"
            data-state="hidden"
            class="v7-checkbox v7-input-field js-v7-input-field"
            <?= $required ? 'required' : ''; ?>
            <?= $checked ? 'checked' : ''; ?>
        >
        <span class="v7-checkbox-icon icon icon-check"></span>
        <span class="v7-checkbox-description">
            <?= $label ?>
        </span>
        <span class="v7-input-info js-v7-input-info">
        <span><?= esc_html($requiredMessage) ?? ''; ?></span>
        <span class="material-icons v7-input-warning">warning</span>
        </span>
    </label>
</div>
