<?php
namespace Instapage\Helpers;

/**
 * A helper used to perform actions before WP initialization.
 * 
 * Caution! Native WP functions can't be used here!
 */
class PreWpHelper {
  
  /**
   * Returns a scheme based on server settings
   * 
   * @return string http or https
   */
  private static function getScheme() {
    $isHttps = $_SERVER['HTTPS'] ?? $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? false;

    if ($isHttps) {
      return 'https';
    }

    return 'http';
  }

  /**
   * Returns site URL. It will be a value from $_SERVER['HTTP_HOST'].
   * 
   * @return string Site URL.
   */
  public static function getSiteUrl() : string {
    $scheme = self::getScheme();
    return $scheme . '://' . $_SERVER['HTTP_HOST'];
  }

  /**
   * Returns an absolute path to current template.
   * 
   * @return string Template directory.
   */
  public static function getTemplateDirectory() : string {
    // removes '/v5/helpers' from current directory path
    return substr(dirname(__FILE__), 0, -11);
  }

  /**
   * Makes a PHP redirect if it's possible
   * 
   * @param string $url URL to redirect to.
   */
  public static function redirect(string $url) {
    if (!headers_sent()) {
      header('Location: ' . $url);
    }
  }
}
