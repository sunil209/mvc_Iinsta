<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $class            Section CSS class. Optional.
 * @param array  $panel            An array with data to loop over: ['image', 'imageRetina', 'alt']
 * @param string $panelVariant     Variant of a panel component, e.g. 'label'.
 * @param string $gaCategory       Category of event send by event dispatcher elements to Google Analytics
 *
 * @example Basic ACF example with default variant
 * Component::render('v70/panel-repeater');
 * @endexample
 */

use \Instapage\Classes\Component;

if (empty($panels) || !is_array($panels)) {
    return;
}

$contentVariant = [1 => 'single-', 2 => 'double-', 4 => 'double-'];
?>
<section class="
    v7
    <?= $isFlat ? 'v7-section-darker v7-py-80 v7-py-lg-100 v7-flat-panel-section' : 'v7-mt-80' ?>
    <?= esc_attr($sectionClass) ?>">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50 ' . ($divisionClass ?? '')
        ]);
    }
    ?>
    <div class="v7-content v7-<?= $contentVariant[count($panels)] ?? '' ?>panel-container">
        <?php
        foreach ($panels as $panel) {
            Component::render(
                'v70/panel',
                ($isFlat ? 'flat' : 'default'),
                array_merge(
                    $panel,
                    [
                        'class' => $class,
                        'layout' => $layout,
                        'gaCategory' => $gaCategory,
                        'circleBtn' => $circleBtn
                    ]
                )
            );
        }
        ?>
    </div>
</section>
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
