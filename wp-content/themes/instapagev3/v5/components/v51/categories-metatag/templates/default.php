<?php
/**
 * Template file. Template params are stored in $params array
 */

use \Instapage\Classes\Factory;

$page = getV5Page();

if (is_single() && $page === 'post'):
  $model = Factory::getModel($page);
  $ipBlogCategories = $model->getIpBlogCategories();
  ?>
  <?php if (!empty($ipBlogCategories)): ?>
    <meta name="ip-blog-categories" content="<?= esc_attr($ipBlogCategories); ?>" />
  <?php endif; ?>
<?php endif; ?>
