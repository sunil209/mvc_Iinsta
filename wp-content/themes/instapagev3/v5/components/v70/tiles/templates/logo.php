<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array   $tiles      An array with images to loop over: ['image']
 * @param string  $section_title
 * @param string  $section_subtitle
 *
 * @example Example with prefix
 * Component::render('v70/tiles', 'logo');
 * @endexample
 *
 * @example Example without prefix
 * Component::render('tiles', 'logo');
 * @endexample
 */

use Instapage\Classes\Component;

if (empty($tiles) || !is_array($tiles) || empty($tiles[0])) {
    return;
}
?>
<section class="v7 v7-mt-80">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    }
    ?>
    <div class="v7-content v7-tile-container-logos" data-self="sm-only-full" >
        <?php foreach ($tiles as $tile) : ?>
            <div class="v7-tile-logo v7-box v7-box-vertical">
                <img class="v7-tile-logo-img" src="<?= $tile['image'] ?>" alt="<?= esc_attr($tile['title']) ?>" />
            </div>
        <?php endforeach; ?>
    </div>
</section>
