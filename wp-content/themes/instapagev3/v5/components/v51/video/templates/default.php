<?php
/**
 * Template file. Template params are stored in $params array
 * $attributes - associative array of attributes
 * $url        - video url
 */

use \Instapage\Helpers\HtmlHelper;

if (!empty($url)) {
  $videoHtml = wp_oembed_get($url);
  if (!empty($videoHtml)) {
    preg_match('#src="(.*?)"#', $videoHtml, $matches);
    $src = $matches[1];
    $prefix = '';

    if (strpos($src, '?') === false) {
      $prefix = '?';
    } else {
      $prefix = '&';
    }

    if (stripos($src, 'youtube.com')) {
      $src .= $prefix . 'showinfo=0&rel=0&autoplay=1';
    } else if (stripos($src, 'vimeo.com')) {
      $src .= $prefix . 'title=0&byline=0&portrait=0&autoplay=1';
    } else if (stripos($src, 'wistia')) {
      $src .= $prefix . 'autoPlay=1';
    }
  }
}
?>
<div class="video">
  <iframe <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?> data-src="<?= $src; ?>" allowfullscreen></iframe>
  <div class="video-close js-video-close"><i class="material-icons">close</i></div>
</div>
