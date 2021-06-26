<?php
/**
 * Template file. Template params are stored in $params array
 * $attributes  - associative array of attributes
 * $items       - associative array of items:
 *  ['url']     - link url
 *  ['name]     - link name
 */

use Instapage\Helpers\HtmlHelper;
?>

<section class="content label-group" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
  <?php if (isset($items) && !empty($items)): ?>
    <h3><?= __('Related Terms'); ?></h3>
    <?php foreach ($items as $item): ?>
      <a class="btn btn-ghost-cta" href="<?= $item['url']; ?>"><?= $item['name']; ?></a>
    <?php endforeach; ?>
  <?php endif; ?>
</section>
