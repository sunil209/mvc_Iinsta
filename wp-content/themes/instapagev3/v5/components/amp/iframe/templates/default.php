<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string     $src     src HTML attribute
 * @param int|string $width   width HTML attribute
 * @param int|string $height  height HTML attribute
 * @param string     $class   class HTML attribute
 * @param string     $title   title HTML attribute
 * @param string     $layout  layout AMP-HTML attribute
 * @param string     $sandbox sandbox AMP-HTML attribute
 *
 * @example Basic example
 * Component::render(
 *   'amp/iframe',
 *   [
 *     'src' => 'http://example.org/',
 *     'width' => 800,
 *     'height' => 600,
 *     'class' => 'my-amp-iframe',
 *     'title' => 'My AMP iframe component example',
 *     'layout' => 'responsive',
 *     'sandbox' => 'allow-scripts allow-same-origin allow-popups allow-presentation'
 *   ]
 * );
 * @endexample
 *
 * @link https://www.ampproject.org/docs/reference/components/amp-iframe
 */

use Instapage\Helpers\HtmlHelper;

if ((isset($src)) && (!empty($src))) {
  $attributes = [];
  foreach ($params as $name => $value) {
    if (!is_null($value)) {
      $attributes[] = sprintf('%s="%s"', $name, $value);
    }
  }

  echo sprintf('<amp-iframe %s allowfullscreen></amp-iframe>', implode(' ', $attributes));
}
