<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string     $src         src HTML attribute
 * @param string     $srcset      srcset HTML attribute
 * @param int|string $width       width HTML attribute
 * @param int|string $height      height HTML attribute
 * @param string     $class       class HTML attribute
 * @param string     $alt         alt HTML attribute
 * @param string     $layout      layout AMP-HTML attribute
 * @param array      $attributes  associative array of attributes
 *
 * @example Basic example
 * Component::render(
 *   'amp/img',
 *   [
 *     'src' => 'http://via.placeholder.com/150x150',
 *     'width' => 150,
 *     'height' => 150
 *   ]
 * );
 * @endexample
 *
 * @link https://www.ampproject.org/docs/reference/components/amp-img
 */

use Instapage\Helpers\HtmlHelper;

$tag[] = '<amp-img';
if ((isset($attributes)) && (!empty($attributes))) {
  $tag[] = HtmlHelper::renderAttributes($attributes);
}
foreach (['src', 'srcset', 'width', 'height', 'class', 'alt', 'layout'] as $property) {
  if ((isset($$property)) && (!empty($$property))) {
    $tag[] = $property . '="' . $$property . '"';
  }
}
$tag[] = '></amp-img>';

if ((isset($src)) && (!empty($src))) {
  echo implode(' ', $tag);
}
