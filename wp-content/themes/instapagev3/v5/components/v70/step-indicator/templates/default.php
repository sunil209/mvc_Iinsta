<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param int  $currentStep    Integer indicated the current step of the form
 * @param int  $maxStep        Integer indicated the maximum number of steps in the form
 *
 * @example Usage
 * Component::render('step-indicator', ['currentStep' => 1, 'maxStep' => 3]);
 * @endexample
*
*/

?>

<p class="v7-step-indicator-text v7-label-grey">Step <?= esc_html($currentStep) ?> of <?= esc_html($maxStep) ?></p>
<div class="v7-mt-5 v7-step-indicator-wrapper">
    <?php for ($i = 1; $i <= $maxStep; $i++) : ?>
        <span
            class="v7-step-indicator-stripe <?= $currentStep >= $i ? 'v7-bg-ocean' : 'v7-bg-fog' ?>">
        </span>
    <?php endfor; ?>
</div>
