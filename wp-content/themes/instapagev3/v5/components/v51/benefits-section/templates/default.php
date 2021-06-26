<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $section    CSS section class
 * @param string $class      CSS class
 * @param string $title      Section title
 * @param string $subtitle   Section subtitle
 * @param string $layout     Section visual structure
 * @param string $panels     Set if blocks should be wrapped by panels
 * @param array  $benefits   An array with data to loop over: ['icon', 'name', 'description']
 * @param array  $attributes Associative array of attributes
 */

use Instapage\Classes\Component;
use Instapage\Helpers\HtmlHelper;
?>

<div class="<?= (isset($section)) ? $section : ''; ?>">
  <?php if (!empty($benefits)): ?>
    <div class="benefits content">
      <?php if (!empty($title)): ?>
        <header class="division-header">
          <h2><?= $title; ?></h2>
          <?php if (!empty($subtitle)): ?>
            <p><?= $subtitle; ?></p>
          <?php endif; ?>
        </header>
      <?php endif; ?>
      <section class="benefits-content <?= (isset($class)) ? $class : ''; ?> <?= (isset($panels)) ? 'with-panels' : ''; ?>" data-layout="<?= isset($layout) ? $layout : ''; ?>" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
        <?php foreach ($benefits as $benefit): ?>
          <div class="benefits-item <?= (isset($panels)) ? 'panel panel-block' : ''; ?>">
            <header class="benefits-header">
              <img class="benefits-icon lazyload" data-src="<?= $benefit['icon']; ?>" alt="<?= esc_attr($benefit['name']); ?>">
              <?php if (!empty($benefit['name'])): ?>
                <h5><?= $benefit['name']; ?></h5>
              <?php endif; ?>
            </header>
            <p class="benefits-description"><?= $benefit['description']; ?></p>
          </div>
        <?php endforeach; ?>
      </section>
      <?php if (!empty($slot)): ?>
        <footer class="division-footer">
          <?= $slot; ?>
        </footer>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>
