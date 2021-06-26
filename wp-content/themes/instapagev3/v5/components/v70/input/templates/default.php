<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $type                      Type of input element, default text
 * @param string $placeholder               Text to be displayed as input element placeholder
 * @param string $name                      Name of input element
 * @param string $value                     Value of input element
 * @param string $requiredMessage           Text to be displayed as message if input has empty value and is required
 * @param string $invalidMessage            Text to be displayed as message if input element has invalid value and is required
 * @param bool   $required                  Decide if input element is required
 * @param string $label                     Label describing input element
 * @param bool   $businessEmailValidation   Should we validate if mail is bussines one?
 *
 * @example Usage
 * Component::render(
 *   'input',
 *   [
 *     'type' => 'email',
 *     'placeholder' => 'Email',
 *     'name' => 'email',
 *     'value' => 'example@example.com',
 *     'requiredMessage' => 'Please enter your work email',
 *     'invalidMessage' => 'Please enter valid work email',
 *     'required' => true,
 *     'label' => 'Email'
 *   ]
 * );
 * @endexample
 */

?>

<div class="v7-input">
    <input
        type="<?= esc_attr($type) ?? 'text'; ?>"
        value="<?= esc_attr($value) ?? ''; ?>"
        placeholder=" "
        name="<?= esc_attr($name) ?? ''; ?>"
        data-required-message="<?= esc_attr($requiredMessage) ?? ''; ?>"
        data-invalid-message="<?= esc_attr($invalidMessage) ?? ''; ?>"
        class="v7-input-field js-v7-input-field"
        <?= $required ? 'required' : ''; ?>
        <?= $businessEmailValidation ? 'data-validation="businessEmail"' : ''; ?>
    >
    <label class="v7-input-label"><?= esc_html($label) ?? ''; ?></label>
    <span class="v7-input-info js-v7-input-info">
        <span><?= esc_html($requiredMessage) ?? ''; ?></span>
        <span class="material-icons v7-input-warning">warning</span>
    </span>
    <div class="v7-input-bar"></div>
</div>
