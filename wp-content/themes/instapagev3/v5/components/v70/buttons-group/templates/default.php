<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $buttons Associative array of buttons
 * @param string $slot    Custom HTML snippet
 *
 * @example Basic usage
 * Component::render('buttons-group', ['buttons' => $buttons];
 * @endexample
 *
 */

use Instapage\Classes\Component;

?>

<div class="<?= $class ?? '' ?> v7-btn-group text-center">
    <?php
    foreach ($buttons as $button) {
        Component::render('button', $button);
    }
    ?>
</div>
