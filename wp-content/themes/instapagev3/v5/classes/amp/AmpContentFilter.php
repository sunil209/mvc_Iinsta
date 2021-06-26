<?php
namespace Instapage\Classes\Amp;

/**
 * Encapsulates single AmpContentFilter
 */
class AmpContentFilter {
  /**
   * @var string $name Name of filter
   */
  private $name;

  /**
   * @var callable $callback Filter callback function. Signature is callable(string $input) : string $output
   */
  private $callback;

  /**
   * Constructor
   * @todo Add setters instead of direct operations on object properties.
   * @todo Throw exceptions in setters in case of any issues
   */
  public function __construct($name, $callback) {
    $this->name = $name;
    $this->callback = $callback;
  }

  /**
   * Returns filter name
   * @return string
   * @see    self::getCallback()
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Returns filter callback
   * @return callable Function signature is callable(string $input) : string $output
   * @see    self::getName()
   */
  public function getCallback() {
    return $this->callback;
  }

  /**
   * Performs str_replace on given $input
   * @param  string $input
   * @param  string|array $search
   * @param  string|array $replace
   * @return string Output with replaced strings
   * @see    self::regexReplace()
   * @see    self::regexCallback()
   */
  public static function simpleReplace($input, $search, $replace) {
    return str_replace($search, $replace, $input);
  }

  /**
   * Performs preg_replace on given $input
   * @param  string $input
   * @param  string $pattern
   * @param  string $replace
   * @return string Output with replaced strings
   * @see    self::simpleReplace()
   * @see    self::regexCallback()
   */
  public static function regexReplace($input, $pattern, $replace) {
    return preg_replace($pattern, $replace, $input);
  }

  /**
   * Performs preg_replace_callback on given $input
   * @param  string $input
   * @param  string $pattern
   * @param  string $replace
   * @return string Output with replaced strings
   * @see    self::simpleReplace()
   * @see    self::regexReplace()
   */
  public static function regexCallback($input, $pattern, $replace) {
    return preg_replace_callback($pattern, $replace, $input);
  }
}
