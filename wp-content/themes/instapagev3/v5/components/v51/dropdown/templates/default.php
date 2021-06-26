<?php
/**
 * Template file. Template params are stored in $params array
 * $title       - dropdown title
 * $icon        - bool value defining icon in dropdown title
 * $options     - associative array of options
 * $isOpen      - bool value defining default state
 * $attributes  - associative array of attributes
 */

use Instapage\Helpers\HtmlHelper;
?>
<div class="dropdown dropdown-listing">
    <span class="dropdown-trigger ">
      <?php if ((isset($options)) && (!empty($options))): ?>
        <span class="dropdown-text">
          <?= $title; ?>
        </span>
        <?php if ((isset($icon)) && (!empty($icon))): ?>
          <i class="material-icons dropdown-listing-icon">keyboard_arrow_down</i>
        <?php endif; ?>
      <?php endif; ?>
    </span>
    <?php if ((isset($options)) && (is_array($options)) && (!empty($options))): ?>
      <div class="dropdown-list">
        <?php foreach ($options as $option): ?>
          <a class="dropdown-option <?= isset($option['class']) ? $option['class'] : ''; ?>" <?= isset($option['attributes']) ? HtmlHelper::renderAttributes($option['attributes']) : ''; ?> href="<?= isset($option['url']) ? $option['url'] : $option['id']; ?>"><?= $option['name']; ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
</div>
