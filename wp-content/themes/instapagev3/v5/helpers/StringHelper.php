<?php
namespace Instapage\Helpers;

use Instapage\Helpers\PreWpHelper;

class StringHelper {
  public static function checkIfRefererIsValid(string $referer, string $validReferer): bool {
    $parsedReferer = parse_url($referer);

    $host = $parsedReferer['host'] ?? '';

    return static::stringEndsWith($host, $validReferer);
  }

  public static function stringEndsWith(string $haystack, string $needle): bool {
    $length = strlen($needle);
    if ($length == 0) {
      return true;
    }

    return (substr($haystack, -$length) === $needle);
  }

  public static function toStudlyCaps($text, $separator = '-') {
    return str_replace(' ', '', ucwords(str_replace($separator, ' ', $text)));
  }

  public static function toSlug($text, $separator = '-') {
    return strtolower(preg_replace(
            '#([^a-z0-9\-\_])#',
            $separator . '$1',
            lcfirst($text))
           );
  }

  public static function getPathFromClassname($className, $dirOnly = false) {
    $prefix = 'Instapage\\';
    $baseDir = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, PreWpHelper::getTemplateDirectory() . '/v5/');
    $len = strlen($prefix);
    if (strncmp($prefix, $className, $len) !== 0) {

      return;
    }

    $relativeClass = substr($className, $len);
    $file = $baseDir . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativeClass) . '.php';
    $pathinfo = pathinfo($file);
    $dirname = substr($pathinfo['dirname'], strlen($baseDir));
    $outputDirname = '';

    for ($i = 0; $i < strlen($dirname); ++$i) {

      if ($i !== 0 && $dirname[$i-1] != DIRECTORY_SEPARATOR && ctype_upper($dirname[$i])) {
        $outputDirname .= '-';
      }

      $outputDirname .= $dirname[$i];
    }

    $dirname = $outputDirname;

    if ($dirOnly) {

      return strtolower($dirname);
    }

    return $baseDir . strtolower($dirname) . DIRECTORY_SEPARATOR . $pathinfo['basename'];
  }

  /**
   * Truncates string to given length.
   * If string is to cut in the middle of the word - returned string will be shorter.
   * Also appends `...` at the very end
   * @param  string $text
   * @param  int $length
   * @return string
   */
  public static function truncate($text, $length) {
    $string = mb_substr($text, 0, $length - 1, 'UTF-8');
    return (mb_strlen($text, 'UTF-8') > $length) ? preg_replace('/ [^ ]*?$/', '&hellip;', $string) : $text;
  }

  /**
   * Converts namespace of a class to version
   * @param  string $namespace Namespace of a class
   * @return string
   */
  public static function namespaceToVersion($namespace) {
    $array = explode('\\', $namespace);
    return strtolower($array[count($array) - 2]);
  }

  /**
   * Converts namespace of a class to identifier
   * @param  string $namespace Namespace of a class
   * @return string
   */
  public static function namespaceToIdentifier($namespace) {
    $array = explode('\\', $namespace);
    return strtolower(end($array));
  }

  /**
   * Wrapper for `parse_url` function`
   * @param  string $url       The URL to parse. Invalid characters are replaced by _.
   * @param  int    $component Specify one of PHP_URL_SCHEME, PHP_URL_HOST, PHP_URL_PORT, PHP_URL_USER, PHP_URL_PASS, PHP_URL_PATH, PHP_URL_QUERY or PHP_URL_FRAGMENT to retrieve just a specific URL component as a string (except when PHP_URL_PORT is given, in which case the return value will be an integer). Defaults to `-1`
   * @return mixed
   * @link   http://php.net/manual/en/function.parse-url.php
   */
  public static function parseUrl() {
    return call_user_func_array('parse_url', func_get_args());
  }

  /**
   * Converts output of `parse_url` back to string
   * @param  array $parsedUrl Array created by calling `parse_url`
   * @return string
   * @link   http://php.net/manual/en/function.parse-url.php#106731
   */
  public static function unParseUrl($parsedUrl) {
    $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
    $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
    $port = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
    $user = isset($parsedUrl['user']) ? $parsedUrl['user'] : '';
    $pass = isset($parsedUrl['pass']) ? ':' . $parsedUrl['pass']  : '';
    $pass = ($user || $pass) ? "$pass@" : '';
    $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
    $query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
    $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';
    return "$scheme$user$pass$host$port$path$query$fragment";
  }

  public static function checkIfStringHasSuffix(string $stringToCheck, string $suffix) : bool {
    $stringLength = strlen($stringToCheck);
    $suffixLength = strlen($suffix);

    if ($suffixLength > $stringLength) {
      return false;
    }

    return substr_compare(
            $stringToCheck,
            $suffix,
            $stringLength - $suffixLength,
            $suffixLength) === 0;
  }

  /**
   * Input URL can be relative [than it will be relative to instapage website url] or full url.
   *
   * @param string $url
   * @return string Parsed url, if url is wrong returns empty string
   */
  public static function parseToFullURL(string $url) : string {
    $url = trim($url);

    // given url is empty, return empty string.
    if (empty($url)) {
      return '';
    }

    // this is full url, there is probably https:// or http:// in url given
    if (strpos($url, '://') !== false) {
      return $url;
    }

    // in url there are dots, so probably this is domain name, but we know that
    // we do not have scheme '://'
    if (strpos($url, '.') !== false) {
      return 'https://' . $url;
    }

    // we assume that every url which does not satisfied earlier condition
    // is relative url
    return get_site_url() . '/' . trim($url, '/');
  }

  /**
   * Get ASCII representation for $input string. What does it mean?
   * Polish characters will be changed for that from ASCII ą->a, ę-e
   */
  public static function getASCII(string $input) : string {
    setlocale(LC_ALL, 'en_US.UTF-8');
    return iconv('UTF-8', 'ASCII//TRANSLIT', $input);
  }
}
