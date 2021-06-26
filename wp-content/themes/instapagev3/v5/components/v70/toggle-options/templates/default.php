<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $toggleOptions    An array of toggle options, each containing:
 *                  string price            Price, numeric or string
 *                  string plan             Type of a pricing plan
 *                  string plan_tooltip     Tooltip for that plan
 *
 * @example Usage
 * Component::render('toggle-options', ['toggleOptions' => $card['price_section']);
 * @endexample
 */

use \Instapage\Classes\Component;
?>

<div class="v7-toggle-wrapper v7-pt-70">
    <div class="v7-toggle-option">
        <?php if ($toggleOptions[0]['plan_tooltip']) : ?>
            <?php Component::render('tooltip', [
                'tooltipText' => $toggleOptions[0]['plan_tooltip']
            ]); ?>
        <?php endif; ?>
        <span class="v7-pricing-plan v7-toggle-option-description"><?= esc_html($toggleOptions[0]['billing']); ?></span>
    </div>
    <input class="v7-toggle" type="checkbox" id="switch" />
    <label class="v7-toggle-track js-toggle-switch" for="switch">toggle</label>
    <div class="v7-toggle-option-reveresed">
        <?php if ($toggleOptions[1]['plan_tooltip']) : ?>
            <?php Component::render('tooltip', [
                'tooltipText' => $toggleOptions[1]['plan_tooltip']
            ]); ?>
        <?php endif; ?>
        <span class="v7-pricing-plan v7-toggle-option-description is-switched">
            <?= esc_html($toggleOptions[1]['billing']); ?>
        </span>
    </div>
    <div class="v7-mt-20 v7-toggle-option-tooltip">
    <?php foreach ($toggleOptions as $toggleOption) :
        echo $toggleOption['plan_tooltip'];
    endforeach; ?>
    </div>
</div>
