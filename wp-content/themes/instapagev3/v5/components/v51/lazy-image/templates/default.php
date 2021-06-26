<?php
/**
 * Template file. Template params are stored in $params array
 *
 * Remember that there is an assumpation that regular image and retina image has the same proportions.
 *
 * For frontend developers: treat this component as an atomic part, style only outer div.
 *
 * @param string $imageClass        Class for image
 * @param string $imageRegularURL   String containing url to regular image - absolutely needed!
 * @param string $imageRetinaURL    String containing url to retina image
 * @param string $width             If you can, pass width of image. It is much, much faster than detecting it by PHP
 * @param string $height            If you can, pass height of image. It is much, much faster than detecting it by PHP
 * @param string $alt               Alternative text for image, renders as alt attribute
 * @param bool   $constrainMaxWidth Do not allow to resize image over 100%
 *
 * @example Usage
 * Component::render('v51/lazy-image', ['imageRegularURL' => 'https://instapage.com/photo.jpg']);
 * @endexample
 */

use Instapage\Helpers\HtmlHelper;

?>

<?php if (($constrainMaxWidth ?? false) === true) : ?>
<div class="insta-lazy-image-width-constrainer" style="max-width: <?= esc_attr($imageMaxWidth) ?>px">
<?php endif; ?>

<div
  class="insta-lazy-image <?= esc_attr($imageClass ?? '') ?>"
  style="padding-bottom: <?= esc_attr($imageProportion * 100) ?>%;"
>
  <img
    class="lazyload"
    data-src="<?= esc_url($imageRegularURL) ?>"
    <?php
      if (!empty($imageRetinaURL)) {
        echo HtmlHelper::renderSrcSet(
          [
            '1x' => esc_attr($imageRegularURL),
            '2x' => esc_attr($imageRetinaURL)
          ],
          'data-srcset'
        );
      }
    ?>
    <?php if (!empty($alt)) : ?>
      alt="<?= esc_attr($alt) ?>"
    <?php endif ?>
  >
  <div class="loader"></div>
</div>

<?php if (($constrainMaxWidth ?? false) === true) : ?>
</div>
<?php endif; ?>

