<?php
/**
 * Shorter name for DIRECTORY_SEPARATOR
 */
if (!defined('DS')) {
  define('DS', DIRECTORY_SEPARATOR);
}

/**
 * App root directory
 */
if (!defined('COMPDOC_ROOT')) {
  define('COMPDOC_ROOT', getcwd() . DS);
}

/**
 * Simple autoloader
 */
spl_autoload_register(function($class) {
  require_once $class . '.php';

});

/**
 * Run
 */
new CompDoc();
