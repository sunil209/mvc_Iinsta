<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $class          CSS class
 * @param string $title          CTA section title
 * @param string $subtitle       CTA section subtitle
 * @param array  $subtitleBottom CTA footnote
 * @param string $slot           Any HMTL to be rendered instead of a button
 * @param array  $attributes     Associative array of attributes
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;
?>

<div class="hero-section cta-section <?= isset($class) ? $class : ''; ?>" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
  <div class="hero-section-intro content">
    <?php if (!empty($title)): ?>
      <span class="heading-primary"><?= $title; ?></span>
    <?php endif; ?>
    <?php if (!empty($subtitle)): ?>
      <p><?= $subtitle; ?></p>
    <?php endif; ?>
    <?php if (!empty($slot)): ?>
      <?= $slot; ?>
    <?php endif; ?>
    <?php Component::render('v51/buttons-group', ['buttons' => $buttons, 'contextID' => $contextID ?? null]); ?>
    <?php if (!empty($subtitleBottom)): ?>
      <p class="hero-section-text"><?= $subtitleBottom; ?></p>
    <?php endif; ?>
  </div>
</div>
