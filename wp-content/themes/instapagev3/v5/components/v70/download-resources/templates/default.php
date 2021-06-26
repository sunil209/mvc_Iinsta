<?php
 /**
 * Template file. Template params are stored in $params array
 *
 * @param string $sectionTitle
 * @param string $sectionSubtitle
 * @param array $resources      An array of panels, each containing:
 *        string image
 *        string image_retina
 *        string title
 *        string download_url
 *        string button_text
 *
 * @example Usage
 * Component::render('download-resources');
 * @endexample
 */

use \Instapage\Classes\Component;

if (empty($resources) || !is_array($resources) || empty($resources[0])) {
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
    <div class="container">
        <div class="row text-center-sm-only">

            <?php foreach ($resources as $resource) : ?>
                <div class="v7-mb-30 text-center col-sm-12 col-md-4">
                    <?php Component::render(
                        'v51/image',
                        [
                            'image' => $resource['image'] ?? '',
                            'imageRetina' => $resource['image_retina'] ?? '',
                            'class' => 'img-responsive v7-mx-auto',
                            'onlyLazyImageClass' => true
                        ]
                    ); ?>
                    <h3 class="v7-heading-large-lg-xxlarge v7-pt-20 v7-pt-md-30 v7-pb-10 v7-pb-md-20">
                        <?= esc_html($resource['title'] ?? '') ?>
                    </h3>
                    <?php if (!empty($resource['download_url'])) :
                        Component::render('button', [
                            'url' => $resource['download_url'] ?? '',
                            'text' => $resource['button_text'] ?? '',
                            'class' => 'v7-btn-ghost-cta',
                            'isDownloadable' => true
                        ]);
                    endif; ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
