<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array $images                An array of images, each containing at least:
 *                  int $max_width          Key of image array
 *                      int     ID                  Image ID in WP media library
 *                      string  title               Title of image from its filename
 *                      string  url                 Url of image
 *
 * @example Usage
 * Component::dumbRender('responsive-picture', ['images' => $multipleImageOptions]);
 * @endexample
 */

if (empty($images) || !is_array($images)) {
    return;
}
?>

<picture>
    <?php foreach ($images as $max_width => $image) : ?>
        <?php if ($max_width !== 1170) : ?>
            <source srcset="<?= $image['url'] ?>" media="(max-width: <?= $max_width ?>px)">
        <?php else : ?>
            <img class="v7-header-bg-img" src="<?= $image['url'] ?>">
        <?php endif; ?>
    <?php endforeach; ?>
</picture>
