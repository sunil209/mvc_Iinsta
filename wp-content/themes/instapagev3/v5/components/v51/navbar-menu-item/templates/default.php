<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $items        An array with data to loop over: ['url', 'title', 'classes', 'thumbnail_id']
 */

$image = wp_get_attachment_image_url($item['thumbnail_id'], $item['image_size']);
?>

<a href="<?= $item['url']; ?>" class="dropdown-option <?= implode(' ', $item['classes']); ?>">
  <?php if ($image): ?>
    <i class="material-icons dropdown-option-icon">
      <img src="<?= $image; ?>">
    </i>
  <?php else: ?>
    <i class="material-icons dropdown-option-icon"><?= $item['classes'][0]; ?></i>
  <?php endif; ?>
  <span><?= $item['title']; ?></span>
</a>
