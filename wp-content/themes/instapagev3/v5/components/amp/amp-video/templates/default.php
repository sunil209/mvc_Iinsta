<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string     $src     src HTML attribute
 * @param int|string $width   width HTML attribute
 * @param int|string $height  height HTML attribute
 *
 * @example Basic example
 * Component::render(
 *   'amp/amp-video',
 *   [
 *     'src' => 'http://example.org/',
 *     'width' => 800,
 *     'height' => 600,
 *   ]
 * );
 * @endexample
 *
 * @link https://www.ampproject.org/docs/reference/components/amp-video
 */

use Instapage\Helpers\HtmlHelper;

?>

<?php if (!empty($src) && !empty($width) && !empty($height)) : ?>
  <amp-video controls
    src="<?= esc_attr($src) ?>"
    width="<?= esc_attr($width) ?>"
    height="<?= esc_attr($height) ?>"
    poster="<?= get_template_directory_uri() . '/v5/assets/images/grey-placeholder-1280x720.png' ?>"
    layout="responsive">

    <div fallback>
      <p><?= esc_attr('This browser does not support the video element.') ?></p>
    </div>
  </amp-video>
<?php endif; ?>
