<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title      Menu title
 * @param array  $items      Associative array of menu items: ['url', 'target', 'classes', 'title']
 * @param array  $attributes Associative array of attributes
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;
?>
<div class="lg-tb-hidden main-footer-column">
  <?php if (isset($title)): ?>
    <h4 class="main-footer-menu-title"><?= $title; ?></h4>
  <?php endif; ?>
  <?php if (!empty($items)): ?>
    <?php ob_start(); ?>
    <ul class="main-footer-menu" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
      <?php foreach ($items as $item): ?>
        <li class="main-footer-menu-option ">
          <a href="<?= $item['url']; ?>" class="v7-btn-flat-black" <?= (!empty($item['target'])) ? sprintf('target="%s"', $item['target']) : ''; ?>>
            <span><?= __($item['title']); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php
    $menuContent = ob_get_contents();
    ob_end_clean();
    echo $menuContent;
  endif; ?>
</div>
<?php
  // Rendering the mobile version of footer menu. HTML will be hidden on desktops
  if (!($isInline ?? false)): ?>
    <div class="lg-tb-visible accordion-group">
      <?php Component::render('v51/accordion', ['isEditable' => false, 'items' => [
        ['title' => $title, 'excerpt' => $menuContent]
        ]]);
      ?>
    </div>
<?php endif; ?>
