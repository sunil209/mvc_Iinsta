<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $tiles      An array with data to loop over: ['image', 'title', 'url', 'moreText']
 * @param string  $section_title
 * @param string  $section_subtitle
 * @param bool    $isAnimated   Should tiles have animation on hover
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
$isAnimated = $isAnimated ?? true;
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
    <div id="v7-tiles-grid" class="v7-content v7-tile-container-hover">
        <?php foreach ($tiles as $tile) : ?>
            <?php if ($isAnimated) : ?>
                <a
                    class="v7-box v7-box-vertical v7-tile-hover v7-box-clickable v7-tile-hover-animation tiles-grid-item"
                    href="<?= esc_url($tile['url']) ?>"
                >
            <?php else : ?>
                <div class="v7-box v7-box-vertical v7-tile-hover">
            <?php endif; ?>
                <div class="v7-tile-hover-img-box">
                    <img class="v7-tile-hover-img" src="<?= $tile['image'] ?>" alt="<?= esc_attr($tile['title']) ?>" />
                </div>
                <div class="v7-tile-hover-copy">
                    <h4 class="v7-heading-basic v7-tile-hover-title"><?= esc_html($tile['title']) ?></h4>
                    <p class="white v7-tile-hover-subtitle"><?= esc_html($tile['moreText']) ?></p>
                </div>
                <?php if ($isAnimated) : ?>
                    <img
                        class="v7-tile-hover-icon"
                        src="<?= get_template_directory_uri() . '/v5/components/v70/tiles/img/arrow-right-top.svg' ?>"
                        alt="Panel arrow"
                    >
                <?php endif; ?>
            <?php if ($isAnimated) : ?>
                </a>
            <?php else : ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>
