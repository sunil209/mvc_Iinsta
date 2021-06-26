<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array   $tiles      An array with data to loop over: ['image', 'title', 'url', 'moreText']
 * @param string  $section_title
 * @param string  $section_subtitle
 * @param string  $layout     Type of grid layout, e.g. default, features, quadruple
 * @param string  $class      Optional class for tile container to help with styling
 * @param string  $gaCategory Category of event send by event dispatcher elements to Google Analytics
 *
 * @example Example with prefix
 * Component::render('v70/tiles');
 * @endexample
 *
 * @example Example without prefix
 * Component::render('tiles');
 * @endexample
 */

use Instapage\Classes\Component;

if (empty($tiles) || !is_array($tiles) || empty($tiles[0])) {
    return;
}
?>
<section
    class="
        v7 v7-mt-80
        <?= ($layout ?? '') === 'features' ? 'v7-mb-80 js-tile-section' : '' ?>
    "
>
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    }
    ?>
    <div
        class="
            v7-content
            <?php
            switch ($layout ?? '') {
                case 'features':
                    echo 'v7-tile-container-features';
                    break;
                case 'two':
                    echo 'v7-tile-container-double';
                    break;
                case 'four':
                    echo 'v7-tile-container-quadruple';
                    break;
                default:
                    echo 'v7-tile-container';
            }; ?>
            <?= esc_attr($class) ?>
        "
        data-self="sm-only-full"
    >
        <?php foreach ($tiles as $tile) : ?>
            <a
                class="v7-box v7-box-vertical v7-box-clickable v7-tile"
                href="<?= esc_url($tile['url']) ?>"
                <?php
                // Please be really careful when editing this component,
                // this can change GA Events (GA Event cannot be deleted or altered)
                Component::render(
                    'generic/ga-event-dispatcher',
                    [
                        'category' => $gaCategory ?? '',
                        'label' => $tile['title'] ?? ''
                    ]
                )
                ?>
            >
                <div class="v7-tile-image">
                    <img src="<?= $tile['image'] ?>" alt="<?= esc_attr($tile['title']) ?>" />
                </div>
                <div class="v7-tile-copy">
                    <h4 class="v7-tile-title"><?= $tile['title'] ?></h4>
                    <?php
                    if (!empty($tile['moreText'])) {
                        echo '<span class="v7-btn v7-btn-flat">'
                            . esc_html($tile['moreText'])
                            . '</span>';
                    }
                    ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
