<?php
/*
Plugin Name: Devsite Indicator
Plugin URI: http://instapage.com
Description: Adds developers site indicator in theme
Author: Instapage
Version: 1.1
Author URI: https://instapage.com
*/

function displayDevSiteIndicator() {
  $name = (defined('WP_DEVNAME')) ? ': ' . constant('WP_DEVNAME') : '';
  $version = '';
  if (!is_admin()) {
    $version =  '(v.5.1)';
  }
  $style = 'position: fixed; z-index: 99999; bottom: 0; left: 0; background-color: green; font-size: 12px; color: white; padding: 5px; display: inline-block;';
  $template = '<div id="devsite-indicator" style="%1$s">DEV Version %2$s%3$s</div>';
  printf($template, $style, $name, $version);
}

if (defined('WP_DEVSITE') && WP_DEVSITE) {
  add_action('wp_footer', 'displayDevSiteIndicator');
  add_action('admin_footer', 'displayDevSiteIndicator');
}
