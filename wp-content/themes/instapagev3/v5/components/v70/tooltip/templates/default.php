<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $tooltipText     Tooltip copy
 *
 * @example Usage
 * Component::render('tooltip', ['tooltipText' => 'Test123');
 * @endexample
 */

?>

<i class="v7-icon-help material-icons v7-tooltip">
    help_outline
    <div class="v7-tooltip-wrapper">
        <span class="v7-tooltip-text">
            <?= wp_kses($tooltipText, [
                'span' => [
                    'class' => [],
                ],
            ]); ?>
        </span>
    </div>
</i>
