<?php
use Instapage\Helpers\HtmlHelper;

/**
 * Template file. Template params are stored in $params array
 * $title            - division title
 * $subtitle         - division subtitle
 * $class            - division padding classes
 */

if (empty($title)) {
    return;
}
?>
<header class="v7-content-md text-center <?= esc_attr($class ?? ''); ?>">
    <h2 class="h1"><?= $title; ?></h2>
    <?php
    if (!empty($subtitle)) {
        echo HtmlHelper::setParagraph($subtitle);
    }
    ?>
</header>
