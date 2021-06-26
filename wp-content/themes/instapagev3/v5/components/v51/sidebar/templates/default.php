<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title         Sidebar title
 * @param string $sidebarClass  Sidebar additional classes
 * @param string $sidebarMobile Here is the slot for sidebar mobile version
 * @param array  $options       An array with data to loop over: ['class', 'url', 'name', 'attributes']
 * @param array  $attributes    Associative array of attributes
 */

use Instapage\Helpers\HtmlHelper;
?>

<div class="sidebar  <?= isset($sidebarClass) ? $sidebarClass : ''; ?>" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
  <h3 class="sidebar-title"><?= $title; ?></h3>
  <?php if ((is_array($options)) && (!empty($options))): ?>
    <ul class="sidebar-menu">
      <?php foreach ($options as $option): ?>
        <li>
          <a class="link-rect <?= isset($option['class']) ? $option['class'] : ''; ?>" <?= isset($option['attributes']) ? HtmlHelper::renderAttributes($option['attributes']) : ''; ?> href="<?= isset($option['url']) ? $option['url'] : $option['id']; ?>"><?= $option['name']; ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <?= $sidebarMobile; ?>
</div>
