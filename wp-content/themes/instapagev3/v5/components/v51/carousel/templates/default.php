<?php
/**
 * Template file. Template params are stored in $params array.
 * @param string $headerText Header text for the slider.
 * @param array  $navigationItems    Array of carousel navigation items, to render the navigation HTML:
 *               string pointerImage URL of navigation pointer image.
 *               string altText      Text for alt pointer alt attribute.
 * @param array  $slides             Array of slides:
 *               string image              Slide image.
 *               string imageRetina        image for Retina displays
 *               string video              video for a slide. Displayed only if no image is provided.
 *               string pointerImage       URL of navigation pointer image.
 *               string pointerImageRetina URL of navigation pointer image.
 *               string header             Slide header text.
 *               string subheader          Slide sub-header text.
 *               string text               Slide text
 */

use Instapage\Helpers\HtmlHelper;
?>
<?php
// Getting the carousel navigation
ob_start();
$slideIndex = 1;
?>
<?php
$navigation = ob_get_contents();
ob_end_clean();
?>

<section class="v7 v7-mt-80">
    <div
        class="js-slick-container js-slider-employee slider-employee carousel-wrapper loader-wrapper"
        data-slick-preset="sliderEmployee"
    >
    <div class="loader"></div>
    <?php foreach ($slides as $slide) : ?>
        <?php
        $videoBox = new Instapage\Components\v51\Video\Controller(['url' => $slide['video']]);
        $videoBox->renderDelayed();
        ?>
        <div class="carousel-item js-slick-slide">
            <div class="carousel-img-wrapper">
                <?php if ($slide['image']) : ?>
                    <?php if (!empty($slide['video'])) : ?>
                    <a
                        href="<?= esc_url($slide['video']) ?>"
                        class="carousel-video-wrapper js-video-trigger"
                        data-video-id="<?= $videoBox->getComponentID(); ?>"
                    >
                    <?php else : ?>
                    <div class="carousel-video-wrapper">
                    <?php endif; ?>
                    <img
                        class="img-responsive carousel-img"
                        src="<?= esc_url($slide['image']); ?>"
                        <?= HtmlHelper::renderSrcSet([
                            '1x' => $slide['image'],
                            '2x' => $slide['imageRetina']
                        ]); ?>
                        alt="<?= esc_attr($slide['header']); ?>"
                    >
                    <?php if (!empty($slide['video'])) : ?>
                    <span class="panel-link-video">
                        <span
                            class="btn btn-cta btn-rounded"
                        >
                        <i class="material-icons">play_arrow</i>
                        </span>
                    </span>
                    </a>
                    <?php else : ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="carousel-content content is-narrow">
                <div class="carousel-copy">
                <?php if ($headerText) : ?>
                    <h2 class="h1 v7-mb-20 carousel-heading lg-tb-hidden"><?= esc_html($headerText); ?></h2>
                <?php endif; ?>
                <?php if ($slide['header']) : ?>
                    <h3 class="h2"><?= $slide['header']; ?></h3>
                <?php endif; ?>
                <?php if ($slide['subHeader']) : ?>
                    <p class="carousel-job"><?= $slide['subHeader']; ?></p>
                <?php endif; ?>
                <?php if ($slide['text']) : ?>
                    <p class="carousel-text"><?= $slide['text']; ?></p>
                <?php endif; ?>
                </div>
                <?= $navigation; ?>
            </div>
        </div>
    <?php endforeach; ?>
        <div class="carousel-navigation js-slick-navigation">
            <?php foreach ($navigationItems as $navItem) : ?>
            <a class="carousel-navigation-link js-slick-navigation-item" href="#" data-slide="<?= $slideIndex++; ?>">
            <img
                class="img-responsive carousel-avatar"
                src="<?= esc_url($navItem['pointerImage']['url']); ?>"
                <?= HtmlHelper::renderSrcSet([
                '1x' => $navItem['pointerImage']['url'],
                '2x' => $navItem['pointerImageRetina']['url'] ?? ''
                ]); ?>
                alt="<?= __('Slide to:') . ' ' . esc_attr($navItem['altText']); ?>">
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
