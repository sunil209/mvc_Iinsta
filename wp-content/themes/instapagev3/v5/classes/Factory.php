<?php
namespace Instapage\Classes;

use \Instapage\Helpers\StringHelper;

/**
 * Returns proper class
 */
class Factory {
  /**
   * @var string Name of cache handler to use
   */
  private static $cacheHandler = null;

  /**
   * Returns proper model instance for given page. If required model doesn't exist - it'll return default one
   * @param  string $page - page name used in v5-config.json file
   * @return object
   */
  public static function getModel($page) {
    $namespace = '\Instapage\Models\\';
    $model = $namespace . StringHelper::toStudlyCaps($page);

    if (!class_exists($model)) {
      $model = $namespace . 'Root';
    }

    return new $model;
  }

  /**
   * Returns proper component controller instance. If required controller doesn't exist - it'll return null
   * @param  string $component Component name with optional version
   * @return object|null
   */
  public static function getComponent($component) {
    if (strpos($component, '/') !== false) {
      list($version, $componentName) = explode('/', $component, 2);
    } else {
      $version = 'v70';
      $componentName = $component;
    }

    $className = 'Instapage\Components\\' . $version . '\\' . StringHelper::toStudlyCaps($componentName) . '\Controller';
    if (file_exists(StringHelper::getPathFromClassname($className))) {
      return $className::getInstance();
    } else {
      return null;
    }
  }

  /**
   * Returns first available cache handler.
   * @uses   \Instapage\Classes\Cache\Handler\Memcache::init()
   * @uses   \Instapage\Classes\Cache\Handler\Database::init()
   * @uses   \Instapage\Classes\Cache\Handler\Dummy::init()
   * @return string Cache handler name
   */
  public static function getCache() {
    if (!is_null(self::$cacheHandler)) {
      return self::$cacheHandler;
    }

    $cacheHandlers = [
      'Instapage\Classes\Cache\Handler\Memcache',
      'Instapage\Classes\Cache\Handler\Database',
      'Instapage\Classes\Cache\Handler\Dummy',
    ];
    foreach ($cacheHandlers as $cacheHandler) {
      if ($cacheHandler::init()) {
        self::$cacheHandler = $cacheHandler;
        break;
      }
    }

    return self::$cacheHandler;
  }
}
