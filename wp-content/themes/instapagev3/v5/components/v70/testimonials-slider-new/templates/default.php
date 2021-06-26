<?php
use \Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Component;

// $slides are needed to render component, if they are empty do not output any html
if (empty($slides) || !is_array($slides) || empty($slides[0])) {
    return;
}
?>

<?php
if (!empty($sectionTitle)) {
    echo '<div class="v7-mt-80">';
    Component::dumbRender('division-header', [
        'title' => $sectionTitle,
        'subtitle' => $sectionSubtitle
    ]);
    echo '</div>';
}
?>
<section class="v7 v7-testimonials-slider js-v7-testimonials-slider js-v7-testimonials-new-slider v7-pt-80">
    <?php foreach ($slides as $slide) : ?>
        <div class="v7-testimonials-slide v7-content">
            <div class="v7-testimonial-slide-content v7-mx-auto">
                <img
                    data-src="<?= esc_url($slide['client_photo']['regular']['url'] ?? '') ?>"
                    class="
                        v7-testimonial-client-photo-img
                        v7-mx-auto
                        lazyload
                    "
                    <?php
                    if (!empty($slide['client_photo']['retina']['url'])) {
                        echo HtmlHelper::renderSrcSet(
                            [
                              '1x' => $slide['client_photo']['regular']['url'] ?? '',
                              '2x' => $slide['client_photo']['retina']['url'],
                            ],
                            'data-srcset'
                        );
                    }
                    ?>
                >
                <div class="v7-testimonial-company-logo-container v7-mx-auto v7-mt-20 v7-mt-md-30">
                    <img
                        data-src="<?= esc_url($slide['client_logo']['regular']['url'] ?? '') ?>"
                        class="
                        v7-testimonial-company-logo
                        lazyload
                    "
                    <?php
                    if (!empty($slide['client_logo']['retina']['url'])) {
                        echo HtmlHelper::renderSrcSet(
                            [
                              '1x' => $slide['client_logo']['regular']['url'] ?? '',
                              '2x' => $slide['client_logo']['retina']['url'],
                            ],
                            'data-srcset'
                        );
                    }
                    ?>
                    >
                </div>
                <p class="v7-mt-20 v7-mt-md-30"><?= $slide['comment'] ?? '' ?></p>
                <h4 class="v7-mt-30 v7-mt-md-40"><?= $slide['client']['name'] ?? '' ?></h4>
                <h4 class="v7-testimonial-client-position v7-mt-10 v7-mt-md-20">
                    <?= $slide['client']['position'] ?? '' ?>
                </h4>
            </div>
        </div>
    <?php endforeach ?>
</section>
