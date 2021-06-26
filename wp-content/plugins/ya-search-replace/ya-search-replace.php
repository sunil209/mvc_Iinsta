<?php
/*
Plugin Name: Yet Another Search & Replace
Description: Simple search & replace plugin
Version: 0.2
Plugin URI: https://instapage.com/
Author: Instapage
Author URI: https://instapage.com/
License: GPLv2
*/

defined('ABSPATH') or die('No direct access!');

if (!defined('DS')) {
  define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('YASR_PLUGIN_ABBR')) {
  define('YASR_PLUGIN_ABBR', 'ya-search-replace');
}

if (!defined('YASR_PLUGIN_FILE')) {
  define('YASR_PLUGIN_FILE', __FILE__);
}

if (!defined('YASR_PLUGIN_PATH')) {
  define('YASR_PLUGIN_PATH', dirname(__FILE__));
}

require_once(ABSPATH . DS . 'wp-includes' . DS . 'pluggable.php');
require_once(YASR_PLUGIN_PATH . DS . 'Exceptions' . DS .
  'TemplateException.php');
require_once(YASR_PLUGIN_PATH . DS . 'Exceptions' . DS .
  'TemplateBasePathException.php');
require_once(YASR_PLUGIN_PATH . DS . 'Exceptions' . DS .
  'TemplateFileNotFoundException.php');
require_once(YASR_PLUGIN_PATH . DS . 'Template.php');
require_once(YASR_PLUGIN_PATH . DS . 'Model.php');
require_once(YASR_PLUGIN_PATH . DS . 'Main.php');

new YASearchReplace\Main();
