<?php
/**
 * Template file. Template params are stored in $params array
 * $title              - Section title
 * $items              - associative array of sections to be displayed
 *  ['linkUrl']        - Url
 *  ['linkName']       - Link copy
 */
?>

<?php if (!empty($title)): ?>
  <h3><?= $title; ?></h3>
<?php endif; ?>

<?php if ((!empty($items))): ?>
  <ul>
  <?php foreach ($items as $item): ?>
    <li class="related-link-wrapper">
      <a href="<?= esc_url($item['linkUrl']); ?>" class="related-link"><?= $item['linkName'] ?></a>
    </li>
  <?php endforeach; ?>
  </ul>
  <hr>
<?php endif; ?>
