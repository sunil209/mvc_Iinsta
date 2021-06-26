<?php
/**
 * Template file. Template params are stored in $params array
 * $items       - pagination links returned from getV5Pagination()
 * $attributes  - associative array of attributes
 */

$config = [
  'currentClass' => 'pagination-page-number panel pagination-button',
  'prevClass' => 'link-chameleon pagination-button',
  'nextClass' => 'link-chameleon pagination-button',
  'dotsClass' => 'pagination-page-number panel pagination-button',
  'defaultClass' => 'pagination-page-number panel pagination-button'
];

$current = [
  'currentClass' => 'page-numbers current',
  'prevClass' => 'prev page-numbers',
  'nextClass' => 'next page-numbers',
  'dotsClass' => 'page-numbers',
  'defaultClass' => 'page-numbers'
];

use Instapage\Helpers\HtmlHelper;

if ((isset($items)) && (is_array($items)) && (!empty($items))) {
  foreach ([0, 1] as $n) {
    if (isset($items[$n])) {
      $items[$n] = preg_replace('/\/page\/1(\"|\')/', '$1', $items[$n]);
    }
  }

  foreach ($items as &$item) {
    if (stripos($item, $current['currentClass']) !== false) {
      $item = str_replace('page-numbers current', $config['currentClass'], $item);
      $item = str_replace('<span ', '<span data-state="current" ', $item);
    }

    if (stripos($item, $current['prevClass']) !== false) {
      $item = str_replace($current['prevClass'], $config['prevClass'], $item);
    }

    if (stripos($item, $current['nextClass']) !== false) {
      $item = str_replace($current['nextClass'], $config['nextClass'], $item);
    }

    if (stripos($item, $current['dotsClass']) !== false) {
      $item = str_replace($current['dotsClass'], $config['dotsClass'], $item);
    }

    $item = HtmlHelper::cleanUrl($item);
  }
}
?>
<?php if ((isset($items)) && (is_array($items)) && (!empty($items))): ?>
  <div class="pagination" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
    <?php foreach ($items as &$item): ?>
      <?= $item; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
