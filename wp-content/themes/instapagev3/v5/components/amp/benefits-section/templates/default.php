<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $class      CSS class
 * @param string $title      Section title
 * @param string $layout     Section visual structure
 * @param array  $benefits   An array with data to loop over: ['icon', 'name', 'description']
 * @param array  $attributes Associative array of attributes
 */

use Instapage\Classes\Component;
use Instapage\Helpers\HtmlHelper;
?>

<div class="section-darker">
  <?php if (!empty($benefits)): ?>
    <div class="benefits content is-narrow">
      <?php if (!empty($title)): ?>
        <header class="division-header">
          <h2><?= $title; ?></h2>
        </header>
      <?php endif; ?>
      <section class="benefits-content <?= (isset($class)) ? $class : ''; ?>" data-layout="<?= isset($layout) ? $layout : ''; ?>" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
        <?php foreach ($benefits as $benefit): ?>
          <div class="benefits-item">
            <header class="benefits-header">
             <?php Component::render('amp/img', ['layout' => 'fixed', 'width' => 70, 'height' => 70, 'class' => 'benefits-icon', 'src' => $benefit['icon'], 'alt' => esc_attr($benefit['name'])]); ?>
              <?php if (!empty($benefit['name'])): ?>
                <h5><?= $benefit['name']; ?></h5>
              <?php endif; ?>
            </header>
            <p class="benefits-description"><?= $benefit['description']; ?></p>
          </div>
        <?php endforeach; ?>
      </section>
    </div>
  <?php endif; ?>
</div>
