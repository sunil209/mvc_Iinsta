<?php
/**
 * Template file. Template params are stored in $params array
 * @param string  $section          CSS section class
 * @param string  $class            CSS class
 * @param string  $tite             section title
 * @param string  $subtite          section subtitle
 * @param bool    $narrow           bool value for .is-narrow class
 * @param array   $benefits         An array with data to loop over: ['icon', 'name', 'description']
 * @param string  $layout           section visual structure
 * @param array   $attributes       associative array of attributes
 */
use Instapage\Classes\Component;
use Instapage\Helpers\HtmlHelper;
?>

<?php if (!empty($benefits)): ?>
  <div class="<?= (isset($section)) ? $section : ''; ?>">
    <div class="division content <?= (isset($narrow) && !empty($narrow)) ? 'is-narrow' : ''; ?>">
      <?php if (!empty($title)): ?>
        <header class="division-header">
          <h2><?= $title; ?></h2>
          <p><?= $subtitle; ?></p>
        </header>
      <?php endif; ?>
      <section class="benefits-content <?= (isset($class)) ? $class : ''; ?>" data-layout="<?= isset($layout) ? $layout : ''; ?>" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
        <?php foreach ($benefits as $benefit): ?>
          <div class="benefits-item">
            <img class="benefits-icon" src="<?= $benefit['icon']; ?>" alt="<?= esc_attr($benefit['name']); ?>">
            <div class="benefits-header">
              <?php if (!empty($benefit['name'])): ?>
                <h5><?= $benefit['name']; ?></h5>
              <?php endif; ?>
              <p class="benefits-description"><?= $benefit['description']; ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </section>
    </div>
  </div>
<?php endif; ?>
