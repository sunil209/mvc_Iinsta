<?php
namespace Instapage\Classes\Cache\Handler;

use \Instapage\Classes\Cache\CacheInterface;

/**
 * Dummy cache handler.
 */
class Dummy implements CacheInterface {
  /**
   * @var string Cache key prefix.
   */
  const KEY_PREFIX = 'cache_dummy_';

  /**
   * Creates key to be used by other cache functions based on given $name.
   * @param  string $name Name used to create cache key.
   * @return string Properly formated cache key
   * @uses   self::KEY_PREFIX
   */
  public static function createKey($name) {
    return substr(preg_replace('#[^a-z0-9\_]#i', '_', strtolower(self::KEY_PREFIX . $name)), 0, 64);
  }

  /**
   * Init method.
   * @return void Always returns true
   */
  public static function init() {
    return true;
  }

  /**
   * Creates cache entry.
   * @param  string $key Key used to store data under.
   * @param  mixed $data Data to be stored. It could be simple type, an array or an object.
   * @param  int $expires Cache expiration in seconds.
   * @return bool Always returns false
   * @see    self::get()
   * @see    self::delete()
   */
  public static function set($key, $data, $expires = 0) {
    return false;
  }

  /**
   * Retrieves cache entry.
   * @param  string $key Key used to retrieve data.
   * @return mixed Data retrieved from cache. False instead.
   * @see    self::set()
   * @see    self::delete()
   */
  public static function get($key) {
    return false;
  }

  /**
   * Removes cache entry.
   * @param  string $key Key used to remove data.
   * @return bool Always returns true.
   */
  public static function delete($key) {
    return true;
  }

  public static function deleteByKeySuffix(string $keySuffix) {
    return;
  }
}
