<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title      Menu title
 * @param array  $items      Associative array of menu items: ['url', 'target', 'classes', 'title']
 * @param array  $attributes Associative array of attributes
 * 
 * @example Basic example
 * Component::render('amp/footer-menu', ['title' => __('Menu title here'), 'items' => getV5Menu('v5-footer-title-menu')]);
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;
?>
<amp-accordion disable-session-states class="amp-footer-accordion">
  <section class="expand-item">
    <!-- EXPANDABLE OPTION HEADER -->
    <header class="expand-trigger amp-menu-option accordion">
      <?php if (isset($title)): ?>
        <h4 class="main-footer-menu-title">
          <?= $title; ?>
          <span class="icon icon-chevron-down"></span>
        </h4>
      <?php endif; ?>
    </header>
    <!-- EXPANDABLE MENU -->
    <div class="expand-content accordion-body">
    <?php if (!empty($items)): ?>
      <ul class="main-footer-menu" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
        <?php foreach ($items as $item): ?>
          <li class="main-footer-menu-option ">
            <a href="<?= $item['url']; ?>" <?= (!empty($item['target'])) ? sprintf('target="%s"', $item['target']) : ''; ?>>
              <span><?= __($item['title']); ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    </div>
  </section>
</amp-accordion>
