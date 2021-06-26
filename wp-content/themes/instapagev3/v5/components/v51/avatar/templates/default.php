<?php
/**
 * Template file. Template params are stored in $params array
 * $info        - can be a name with company or a position
 * $image       - image
 * $imageRetina - retina image
 */

use \Instapage\Helpers\HtmlHelper;
?>
<div class="avatar">
  <?php if (isset($image) && !empty($image)): ?>
    <img class="avatar-profile" src="<?= $image; ?>" <?= HtmlHelper::renderSrcSet(['1x' => $image, '2x' => $imageRetina]); ?> alt="<?= esc_attr($info); ?>">
  <?php endif; ?>
  <small class="avatar-title"><?= $info; ?></small>
</div>
