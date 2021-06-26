<?php
 /**
  * Template file. Template params are stored in $params array
  *
  * @param string $class              Class for image
  * @param array  $image              An array of single image: ['url', 'title']
  * @param array  $imageRetina        An array of single image retina: ['url']
  * @param bool   $constrainMaxWidth  Do not allow to resize image over 100%
  *
  * @example Usage
  * Component::render('v51/image', ['class' => 'img-responsive']);
  * @endexample
  */

use \Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Component;
?>

<?php
  if (!empty($image)) {
      if ($onlyLazyImageClass) {
        ?>
        <img
          class="<?= esc_attr($class); ?> lazyload"
          data-src="<?= $image['url']; ?>"
          <?php if (!empty($imageRetina)): ?>
            <?= HtmlHelper::renderSrcSet(
              [
                '1x' => $image['url'],
                '2x' => $imageRetina['url']
              ],
              'data-srcset'
            ); ?>
          <?php endif; ?>
          alt="<?= esc_attr($image['title']); ?>"
        >
        <?php
      } else {
        Component::render(
          'v51/lazy-image',
          [
            'imageClass' => $class,
            'imageRegularURL' => $image['url'],
            'imageRetinaURL' => $imageRetina['url'],
            'alt' => $image['title'],
            'constrainMaxWidth' => $constrainMaxWidth ?? false
          ]
        );
      }
  }
?>
