<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string  $sectionTitle         Title of the section.
 * @param string  $sectionSubtitle      Subtitle of the section.
 * @param array   $repeater             Array of features to loop over, each containing:
 *            string  $icon              Link to an svg icon
 *            string  $title             Title of a feature.
 *            string  $url               URL to a related page to follow.
 *            string  $url_text          Text to represent the URL to follow.
 *
 * @example Default
 *  Component::render('feature-repeater', 'tile');
 *
 * @endexample
 */

use Instapage\Classes\Component;

if (empty($repeater)) {
    return;
}
?>
<section class="v7 v7-mt-80 v7-content">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    } ?>

    <div class="v7-box <?= esc_attr($repeaterLayout) ?>">
    <?php foreach ($repeater as $feature) : ?>
        <div class="v7-feature-in-tile">
            <img class="v7-mt-5" src="<?= esc_url($feature['icon']) ?>" alt="<?= esc_attr($feature['title']) ?>" />
            <div class="v7-ml-20">
                <h4 class="v7-mb-10 v7-feature-in-tile-title"><?= esc_html($feature['title']) ?></h4>
                <?php if (!empty($feature['url'])) :
                    Component::render(
                        'button',
                        [
                            'url' => $feature['url'],
                            'class' => 'v7-btn v7-btn-flat',
                            'text' => $feature['url_text']
                        ]
                    );
                endif ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</section>
