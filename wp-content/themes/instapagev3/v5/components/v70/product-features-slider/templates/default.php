<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string    $title          Title of feature product slider section
 * @param string    $subtitle       Subtitle of feature product slider section
 * @param array     $slides         Array containing slides for products feature
 *                  string title    Title of slide
 *                  array  image    Image for slider
 *                                  array regular   Regular image array [standard array
 *                                                  return from acf image field]
 *                                  array retina    Retina image array [standard array
 *                                                  return from acf image field]
 *
 * Component's model so usage is simple:
 *
 * @example Basic ACF example
 * Component::render('v70/product-features-slider');
 * @endexample
 *
 */

use \Instapage\Classes\Component;

if (empty($slides) || !is_array($slides) || empty($slides[0])) {
    return;
}
?>

<section class="v7 v7-mt-80 v7-product-features text-center">
    <?php Component::dumbRender(
        'division-header',
        ['title' => $title, 'subtitle' => $subtitle, 'class' => 'is-narrow']
    ) ?>
    <?php if (count($slides) > 1) : ?>
    <div class="v7-content">
        <ul class="v7-product-features-navigation js-v7-product-features-navigation v7-mt-40 ">
            <?php for ($i = 0; $i < count($slides); $i++) : ?>
                <li
                    data-product-feature="<?= $i ?>"
                    class="v7-product-features-navigation-item h5"
                    <?= $i === 0 ? 'data-state="active"' : '' ?>
                >
                    <?= esc_html($slides[$i]['title'] ?? '') ?>
                </li>
            <?php endfor ?>
        </ul>
    </div>
    <?php endif; ?>
    <div class="v7-product-features-slider js-v7-product-features-slider">
        <?php foreach ($slides as $slide) : ?>
        <div class="v7-product-feature-slide v7-content">
            <div class="v7-product-feature-slide-content v7-mx-auto">
                <?php if (count($slides) > 1) : ?>
                <h2 class="v7-product-feature-slide-title v7-mt-40 v7-mt-md-50">
                    <?= esc_html($slide['title'] ?? '') ?>
                </h2>
                <?php endif;
                Component::render(
                    'v51/lazy-image',
                    [
                        'imageRegularURL' => $slide['image']['regular']['url'],
                        'imageRetinaURL' => $slide['image']['retina']['url'],
                        'imageClass' => 'v7-mt-10 v7-mt-md-20 v7-mt-lg-30 v7-mt-xl-40',
                        'width' => (int) $slide['image']['regular']['width'],
                        'height' => (int) $slide['image']['regular']['height'],
                        'alt' =>  $slide['image']['regular']['alt']
                    ]
                ); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
