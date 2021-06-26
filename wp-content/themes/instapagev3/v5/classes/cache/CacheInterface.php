<?php
namespace Instapage\Classes\Cache;

/**
 * Interface for cache handlers.
 */
interface CacheInterface {
  /**
   * Creates key to be used by other cache functions based on given $name.
   * @param  string $name Name used to create cache key.
   * @return string Properly formated cache key
   */
  public static function createKey($name);

  /**
   * Init method guaranteed to run once for each request. Can be used to create necessary directories, database tables and so on.
   * @return void
   */
  public static function init();

  /**
   * Creates cache entry. If $key was used before - it'll be overwritten.
   * @param  string $key Key used to store data under.
   * @param  mixed $data Data to be stored. It could be simple type, an array or an object.
   * @param  int $expires Cache expiration in seconds.
   * @return bool True if data are stored in the cache. False instead.
   * @uses   self::createKey()
   * @see    self::get()
   * @see    self::delete()
   */
  public static function set($key, $data, $expires);

  /**
   * Retrieves cache entry. If it's expired - it'll be removed and false will be returned.
   * @param  string $key Key used to retrieve data.
   * @return mixed Data retrieved from cache. False instead.
   * @uses   self::createKey()
   * @see    self::set()
   * @see    self::delete()
   */
  public static function get($key);

  /**
   * Removes cache entry under given $key.
   * @param  string $key Key used to remove data.
   * @return bool True if cache entry was removed. False otherwise.
   * @uses   self::createKey()
   */
  public static function delete($key);

  public static function deleteByKeySuffix(string $keySuffix);
}
