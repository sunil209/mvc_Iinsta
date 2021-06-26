<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $leftRightRow          An array of nav tabs, each containing:
 *               string $label_color    Color value from select
 *               string $row_id         Unique section ID
 *               string $label          Label text
 *
 * @example Usage
 * Component::render('navigation-tabs', 'left-right', ['leftRightRows' => $leftRightRows]);
 * @endexample
 */
?>
<ul class="v7-navigation-tabs v7-navigation-tabs-left-right v7-pt-50">
    <?php
    foreach ($leftRightRows as $leftRightRow) : ?>
        <li class="v7-navigation-tabs-item h5">
            <a
                class="v7-navigation-tabs-link v7-link-<?= esc_attr($leftRightRow['label_color']); ?>"
                href="#<?= esc_attr($leftRightRow['row_id']); ?>"
            >
                <?= esc_html($leftRightRow['label']); ?>
            </a>
        </li>
        <?php
    endforeach; ?>
</ul>
