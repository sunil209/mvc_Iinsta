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
 *               string pointerImage       URL of navigation pointer image.
 *               string pointerImageRetina URL of navigation pointer image.
 *               string header             Slide header text.
 *               string subheader          Slide sub-header text.
 */

use Instapage\Helpers\HtmlHelper;

$slideIndex = 1;
?>

<section class="v7-mt-80 v7 carousel-single">
    <div
      class="js-slick-container js-slider-employee slider-employee carousel-wrapper loader-wrapper"
      data-slick-preset="sliderEmployee"
    >
      <div class="loader"></div>
        <?php foreach ($slides as $slide) : ?>
        <div class="carousel-item js-slick-slide">
            <?php if ($slide['image']) : ?>
                <div class="carousel-img-wrapper-single">
                    <img
                        class="img-responsive carousel-img"
                        src="<?= esc_url($slide['image']); ?>"
                        <?= HtmlHelper::renderSrcSet([
                          '1x' => $slide['image'],
                          '2x' => $slide['imageRetina']
                        ]); ?>
                        alt="<?= esc_attr($slide['header']); ?>"
                    >
                </div>
            <?php endif; ?>
            <?php if ($headerText) : ?>
                <div class="carousel-content v7-content is-narrow">
                    <div class="carousel-copy">
                        <h2 class="v7-heading-xlarge-huge"><?= $headerText; ?></h2>
                        <p><?= $subheaderText ?></p>
                    </div>
                </div>
            <?php endif; ?>
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
