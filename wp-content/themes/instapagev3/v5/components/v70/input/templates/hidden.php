<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string        $name            Name of input element
 * @param string|array  $value           Value of input element, if array passed it allows
 *                                       to render hidden array input (many parametrs value on the same name)
 * @param string        $class           Name of class for input
 * @param string        $id              Name of id of input
 *
 * @example Usage
 * Component::render(
 *   'input',
 *   'hidden',
 *   [
 *     'name' => 'email',
 *     'value' => 'test@gmail.com',
 *   ]
 * );
 * @endexample
 */

$values = (array) $value;

// allow to render hidden input without value
if (!empty($name) && empty($value)) {
    $values = [''];
}

foreach ($values as $value) :
    ?>
    <input
        type="hidden"
        class="<?= esc_attr($class ?? '') ?>"
        name="<?= esc_attr($name ?? '') . (count($values) > 1 ? '[]' : '') ?>"
        id="<?= esc_attr($id ?? '') ?>"
        value="<?= esc_attr($value ?? '') ?>"
    >
    <?php
endforeach;
