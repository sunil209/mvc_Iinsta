<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string sectionTitle       Main section title
 * @param string sectionSubtitle    Text under section title
 * @param string icon               Url for icon
 * @param array  expandableTiles    An array of sections, each containing:
 *               array subsections      An array for sections, each containing:
 *                   string headline        Title of a subsection
 *                   string text            Text of a subsection
 *
 * @example Basic usage
 * Component::render('expandable-item');
 * @endexample
 */

use Instapage\Classes\Component;

if (empty($expandableTiles)) {
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
    <div class="v7 v7-content v7-expandable-tiles-container">
    <?php foreach ($expandableTiles as $expandableTile) :
        if (!empty($expandableTile['subsections']) && !empty($expandableTile['icon'])) : ?>
        <div class="v7-py-30 v7-expandable-tile v7-box v7-box-vertical expand-item js-expand-item">
            <div class="v7-mb-30 v7-expandable-tile-icon-container">
                <img class="v7-expandable-tile-icon" src="<?= esc_url($expandableTile['icon']) ?>">
            </div>
            <?php foreach ($expandableTile['subsections'] as $key => $subsection) :
                if ($key === 0) : ?>
                <h4 class="v7-expandable-tile-title text-center"><?= esc_html($subsection['headline']) ?></h4>
                    <?php if ($layout === 'careers') : ?>
                    <p class="v7-px-30 v7-expandable-tile-text v7-expandable-tile-text-visible text-center">
                        <?= esc_html($subsection['text']) ?>
                    </p>
                    <?php else : ?>
                    <div class="v7-expand-content expand-content">
                        <p class="v7-px-30 v7-expandable-tile-text text-center"><?= esc_html($subsection['text']) ?></p>
                    </div>
                    <?php endif;
                else : ?>
                <div class="v7-expand-content expand-content">
                    <h6 class="v7-expandable-tile-headline text-center">
                        <span class="v7-expandable-tile-headline-background">
                            <?= esc_html($subsection['headline']) ?>
                        </span>
                    </h6>
                    <p class="v7-px-30 v7-expandable-tile-text text-center"><?= esc_html($subsection['text']) ?></p>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <a href="#" class="v7-mt-20 v7-btn v7-btn-flat v7-expand-trigger expand-trigger js-expand-trigger">
                <span class="js-expand-link"><?= __('MORE INFO'); ?></span>
                <i class="material-icons v7-material-icons v7-expandable-icon expand-icon">keyboard_arrow_down</i>
            </a>
        </div>
        <?php endif;
    endforeach; ?>
    </div>
</section>
