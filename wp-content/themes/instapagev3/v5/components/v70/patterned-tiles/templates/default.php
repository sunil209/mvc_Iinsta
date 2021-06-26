<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string sectionTitle       Main section title
 * @param string sectionSubtitle    Text under section title
 * @param array  patternedTiles     An array of sections, each containing:
 *               string title           Title of a subsection
 *               string text            Text of a subsection
 *
 * @example Basic usage
 * Component::render('patterned-tiles');
 * @endexample
 */

use Instapage\Classes\Component;

if (empty($patternedTiles)) {
    return;
}
?>

<section class="v7 v7-mt-80 <?= esc_attr($class) ?>">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    } ?>
    <div class="v7 v7-content v7-patterned-tiles-container">
    <?php foreach ($patternedTiles as $patternedTile) : ?>
        <div class="v7-py-30 v7-box v7-patterned-tile text-center">
        <?php if (!empty($patternedTile['title'])) : ?>
            <h2><?= esc_html($patternedTile['title']) ?></h2>
        <?php endif;
        if (!empty($patternedTile['text'])) : ?>
            <p><?= esc_html($patternedTile['text']) ?></p>
        <?php endif; ?>
            <div class="v7-pattern-paceholder"></div>
        </div>
    <?php endforeach; ?>
    </div>
</section>
