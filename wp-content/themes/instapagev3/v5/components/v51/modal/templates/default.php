<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $html       Any HTML to be displayed within modal
 * @param array  $attributes Associative array of attributes
 *
 * @example Basic usage
 * // Will output modal immediately
 * Component::render('v51/modal', ['html' => '<p>Lorem ipsum</p><p>dolor sit amet</p>']);
 * @endexample
 *
 * @example Delayed rendering
 *  // Will output modal near `</body>`
 * $modal = new \Instapage\Components\V51\Modal\Controller(['html' => '<p>Lorem ipsum</p><p>dolor sit amet</p>']);
 * $modal->renderDelayed();
 *
 * // In this case you can use following code to get class name of it, and for example, show it with some javascript (you need to write it yourself)
 * Component::render('v51/button', ['text' => __('Show'), 'url' => '#', 'class' => 'btn btn-cta', 'attributes' => ['data-modal-id' => $modal->getComponentID()]]);
 * @endexample
 */

use Instapage\Helpers\HtmlHelper;
?>

<div <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?> data-state="<?= (!isset($dataState) || $dataState !== true ) ? 'hidden' : '' ?>">
  <div class="modal-element panel">
    <?= $html; ?>
  </div>
</div>
