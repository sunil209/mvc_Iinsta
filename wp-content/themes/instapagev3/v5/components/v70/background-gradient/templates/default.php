<?php
use Instapage\Classes\Component;

/**
 * Template file. Template params are stored in $params array
 *
 * @param bool   $isBackgroundGradient         Is background gradient set for the page.
 * @param string $backgroundGradientPosition   Where the gradient is positioned - overlapping or over the section.
 *
 * @example Basic ACF example with default variant
 * Component::render('gradient-background');
 * @endexample
 *
 */

if (!$isBackgroundGradient) {
    return;
}
?>

<div
    class="
        v7-gradient-bg
        <?= $backgroundGradientPosition === 'overlap' ? 'v7-gradient-bg-overlapping' : 'v7-gradient-bg-above' ?>
        <?= esc_attr($backgroundGradientClass) ?>
    "
>
</div>

<?php
if (!empty($button)) {
    Component::render(
        'buttons-group',
        [
            'class' => 'v7-pt-10 v7-pt-md-0',
            'buttons' => [$button]
        ]
    );
}
?>
