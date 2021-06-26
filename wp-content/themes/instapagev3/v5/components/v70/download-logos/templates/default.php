<?php
 /**
 * Template file. Template params are stored in $params array
 *
 * @param string $sectionTitle
 * @param string $sectionSubtitle
 * @param array $logos              An array of images, each containing:
 *        string image
 *        string background_color
 *        bool   isBig
 *        string download_url
 *        string button_text
 * @param array $assets              An array of images, each containing:
 *        string image
 *        string title
 *        string download_file
 *
 * @example Usage
 * Component::render('download-logos');
 * @endexample
 */
use \Instapage\Classes\Component;

if (empty($logos) || !is_array($logos) || empty($logos[0])) {
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

            <?php foreach ($logos as $logo) : ?>
                <div class="
                    v7-mb-30
                    <?= ($logo['isBig'] ?? false) ? 'col-sm-12 col-md-6 v7-download-logos-big' : 'col-6 col-md-3 v7-download-logos-small' ?>
                ">
                    <div class="
                        v7-download-logo
                        <?php if (($logo['background_color'] ?? '') === 'blue') {
                            echo 'v7-bg-ocean';
                        } elseif (($logo['background_color'] ?? '') === 'grey') {
                            echo 'v7-bg-dark-old';
                        } else {
                            echo 'v7-download-logo-border';
                        } ?>"
                    >
                        <?php Component::render(
                            'v51/image',
                            [
                                'image' => $logo['image'] ?? '',
                                'class' => 'img-responsive',
                                'onlyLazyImageClass' => true
                            ]
                        ); ?>
                        <span class="v7-download-logo-title"><?= esc_html($logo['title'] ?? '') ?></span>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php foreach ($assets as $asset) : ?>
                <div class="v7-mb-30 col-sm-12 col-md-3">
                    <a
                        class="v7-download-logo-assets v7-download-logo-border"
                        href="<?= esc_url($asset['download_file'] ?? '') ?>"
                        download
                    >
                        <div>
                            <?php Component::render(
                                'v51/image',
                                [
                                    'image' => $asset['image'] ?? '',
                                    'class' => 'img-responsive v7-mx-auto',
                                    'onlyLazyImageClass' => true
                                ]
                            ); ?>
                            <span class="v7-download-logo-assets-title"><?= esc_html($asset['title'] ?? '') ?></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
