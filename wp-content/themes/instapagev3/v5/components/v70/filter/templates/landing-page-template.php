<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $filters                An array of filter sections, each containing:
 *               string filter                  Name of a section title, to be filtered by
 *               string visibility              Variable to decide which filter section should be visible on entry
 * @param array  $template               An array of lp template data from API, containing:
 *               string $name                   The name of LP template in format '- name -'
 *               string $desktop_image          URL for image
 *               string $desktop_image_retina   URL for image
 *               string $mobile_image           URL for image
 *               string $mobile_image_retina    URL for image
 *
 * @example Basic usage
 * Component::render('filter', 'landing-page-template);
 * @endexample
 */

use \Instapage\Helpers\HtmlHelper;

?>

<section class="v7-content v7-mt-80">
    <div class="v7-lp-filter-navigation text-center">
        <?php foreach ($filters as $filter) : ?>
        <a
            class="js-filter-single v7-lp-link-filter"
            data-category="<?= esc_attr($filter['filter']) ?>"
            href="#"
            data-scroll="200"
            data-state="<?= $filter['visibility'] ? 'active' : '' ?>"
        >
            <i class="material-icons v7-lp-link-filter-icon">
                <?= $filter['filter'] === 'desktop' ? 'laptop_mac' : 'phone_iphone' ?>
            </i>
            <?= esc_attr($filter['filter']) ?>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="v7-lp-template-filter v7-mt-40 v7-mt-md-50 js-filter-group fade slow-effect">
        <?php foreach ($filters as $filter) : ?>
        <div
            class="js-filter-element <?= $filter['visibility'] ? '' : 'v7-is-hidden'; ?>"
            data-filter="<?= esc_attr($filter['filter']) ?>"
        >
            <div class="v7-lp-template-<?= $filter['filter'] ?>-wrapper">
                <img
                    class="v7-lp-template-<?= $filter['filter'] ?>-img"
                        src="<?= esc_url($template[$filter['filter'].'_image']) ?>"
                        <?php echo HtmlHelper::renderSrcSet(
                            [
                                '1x' => $template[$filter['filter'].'_image'],
                                '2x' => $template[$filter['filter'].'_image_retina'],
                            ]
                        ); ?>
                    alt="<?= esc_attr($template['name']) ?>"
                >
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
