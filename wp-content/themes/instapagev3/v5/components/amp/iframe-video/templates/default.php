<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string     $url       URL of video
 * @param string     $thumbnail src HTML attribute for AMP-IMG tag serving as fallback
 * @param int|string $width     width HTML attribute
 * @param int|string $height    height HTML attribute
 *
 * @example Basic example
 * Component::render(
 *   'amp/iframe-video',
 *   [
 *     'url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
 *     'thumbnail' => 'http://via.placeholder.com/800x600?Text=Thumbnail',
 *     'width' => 800,
 *     'height' => 600
 *   ]
 * );
 * @endexample
 *
 * @link https://www.ampproject.org/docs/reference/components/amp-iframe
 * @link https://www.ampproject.org/docs/reference/components/amp-img
 */

use Instapage\Helpers\HtmlHelper;

if ((isset($url)) && (!empty($url))) {
  $oembed = _wp_oembed_get_object();
  $provider = $oembed->get_provider($url);
  $data = $oembed->fetch($provider, $url);
  preg_match('#src="(.*?)"#', $data->html, $matches);
  $src = $matches[1];
  $thumbnail = $data->thumbnail_url;
}
?>
<?php if ((isset($src)) && (!empty($src))): ?>
  <amp-iframe layout="responsive" width="<?= $width; ?>" height="<?= $height; ?>" sandbox="allow-scripts allow-same-origin allow-popups allow-presentation" src="<?= $src; ?>" allowfullscreen>
    <amp-img layout="fill" src="<?= $thumbnail; ?>" placeholder></amp-img>
  </amp-iframe>
<?php endif; ?>
