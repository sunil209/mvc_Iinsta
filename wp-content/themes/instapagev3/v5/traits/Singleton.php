<?php
namespace Instapage\Traits;

trait Singleton {
  private static $instance = null;

  public static function getInstance() : self {
    if (is_null(self::$instance)) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  private function __construct() {}
}
