<?php
/**
 * Template file. Template params are stored in $params array
 * 
 * @param string $stage   Content stage. Blog post param that can be set in wp-admin and is displayed as a metatag.
 */

$stage = isset($stage) ? $stage : get_field('content_stage');
?>
<?php if (!empty($stage)): ?>
  <meta name="ip-blog-stage" content="<?= esc_attr($stage); ?>">
<?php endif; ?>
