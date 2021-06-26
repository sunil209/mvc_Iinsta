<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  engagementBox    An array for engagement box, containing:
 *        string title                Main title
 *        string text                 Text copy
 *        array  link                 An array for link, containing:
 *               string text             text to show
 *               string url              url to follow
 *        array  image                An array for image, containing:
 *               array regular           An array for image, containg:
 *                     string url            image url
 *                     string height         image height
 *                     string width          image width
 *                     string title          image title
 *               array retina         An array for image, containg:
 *                     string url            image url
 *                     string height         image height
 *                     string width          image width
 *                     string title          image title
 *
 * @example Basic usage
 * Component::render('engagement-box');
 * @endexample
 */

use Instapage\Classes\Component;

if (empty($engagementBox['title']) || empty($engagementBox['text'])) {
    return;
}
?>

<section class="v7 v7-content v7-mt-80 v7-mt-lg-100 v7-mb-lg-20">
    <div class="v7-box v7-engagement-box">
        <div class="v7-engagement-box-copy">
            <h2 class="h1"><?= wp_kses($engagementBox['title'], ['br' => []]) ?></h2>
            <p class="v7-mb-40"><?= esc_html($engagementBox['text']) ?></p>
            <?php Component::render(
                'button',
                [
                    'text' => $engagementBox['link']['text'],
                    'url' => $engagementBox['link']['url'],
                    'class' => 'v7-btn-flat'
                ]
            ); ?>
        </div>
        <a class="v7-engagement-box-image-wrapper" href="<?= $engagementBox['link']['url'] ?>">
        <?php
        Component::render(
            'v51/image',
            [
                'image' => $engagementBox['image_regular'] ?? '',
                'imageRetina' => $engagementBox['image_retina'] ?? '',
                'onlyLazyImageClass' => true,
                'class' => 'v7-engagement-box-image'
            ]
        ); ?>
        </a>
    </div>
</section>
