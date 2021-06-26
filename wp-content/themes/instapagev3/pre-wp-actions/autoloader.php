<?php
/* Initiation of Instapage autoloader. StringHelper is used by the autoloader, */
define('TEMPLATE_DIR', dirname(__FILE__) . '/..');
require_once(TEMPLATE_DIR . '/v5/helpers/PreWpHelper.php');
require_once(TEMPLATE_DIR . '/v5/helpers/StringHelper.php');
/* Register autoloader. */
spl_autoload_register('instapageAutoloader', true);

/**
 * Register Instapage autoloader.
 * 
 * @param string $class Class name to include
 * 
 * @uses \Instapage\Helpers\StringHelper::getPathFromClassname()
 * 
 * @return void | bool Returns false if class file doesn't exist.
 */
function instapageAutoloader($class) {
  $file = \Instapage\Helpers\StringHelper::getPathFromClassname($class);

  if (!file_exists($file)) {
    return false;
  }

  require($file);
}
