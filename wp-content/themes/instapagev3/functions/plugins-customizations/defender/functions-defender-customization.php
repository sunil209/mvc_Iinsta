<?php

add_filter('wd_render_partial', 'customLockoutPage', 10, 3);

/**
 * Adjust lockout page by using another, custom template.
 * 
 * @param string  $content
 * @param string  $viewFile
 * @param array   $params
 * @return string $content
 */
function customLockoutPage($content, $viewFile, $params) {
  // check if it is locked page template generations
  // if no, do nothing
  if ($viewFile !== 'locked') {
    return $content;
  }
  
  // new, custom view for lockout page
  $overwriteView = get_template_directory() . '/functions/plugins-customizations/defender/views/locked-overwrite.php';
  
  if (!is_file($overwriteView)) {
    return $content;
  }
  
  // get all output from custom view to string and return it
  ob_start();
  ob_implicit_flush(false);
  extract($params, EXTR_OVERWRITE);
  require($overwriteView);

  // and return new content from custom template
  return ob_get_clean();
}
