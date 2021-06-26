<?php
/**
 * Template file. Template params are stored in $params array
 * $text             - list elements text
 * $class            - list styling class
 */
?>
<ul class="list-check <?= (isset($class)) ? esc_attr($class) : ''; ?>">
  <?php if (!empty($items) && is_array($items)) : ?>
    <?php foreach ($items as $item) : ?>
      <li>
        <i class="material-icons list-check-sign">check</i>
        <?= $item['text']; ?>
      </li>
    <?php endforeach; ?>
  <?php endif; ?>
</ul>
