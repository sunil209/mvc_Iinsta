<?php
namespace Instapage\Classes\Cache\Handler;

use \Instapage\Classes\Cache\CacheInterface;

/**
 * Database cache handler.
 */
class Database implements CacheInterface {
  /**
   * @var string Cache key prefix.
   */
  const KEY_PREFIX = 'db_';

  /**
   * @var int Cache entry default lifetime
   */
  const LIFETIME = 3600;

  /**
   * @var string Name of database table used for cache storage.
   */
  const TABLE_NAME = 'cache';

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
   * Init method used to create necessary database table.
   * @return bool True if initialization was successful. False otherwise
   * @uses   self::TABLE_NAME
   */
  public static function init() {
    global $wpdb;

    $result = $wpdb->get_row("SHOW TABLES LIKE '" . $wpdb->prefix . self::TABLE_NAME . "'", OBJECT);
    if (!$result) {
      return $wpdb->query("
        CREATE TABLE `" . $wpdb->prefix . self::TABLE_NAME . "` (
          `key` VARCHAR(64) NOT NULL,
          `data` LONGTEXT NOT NULL,
          `expires` INT(11) UNSIGNED NOT NULL,
          PRIMARY KEY (`key`)
        )
        COLLATE='utf8mb4_unicode_ci' ENGINE=InnoDB
      ");
    } else {
      return true;
    }
  }

  /**
   * Creates cache entry. If $key was used before - it'll be overwritten.
   * @param  string $key Key used to store data under.
   * @param  mixed $data Data to be stored. It could be simple type, an array or an object.
   * @param  int $expires Cache expiration in seconds.
   * @return bool True if data are stored in the cache. False instead.
   * @uses   self::LIFETIME
   * @uses   self::TABLE_NAME
   * @uses   self::createKey()
   * @see    self::get()
   * @see    self::delete()
   */
  public static function set($key, $data, $expires = 0) {
    if (!isset($key) || empty($key) || !isset($data)) {
      return false;
    }

    if (empty($expires)) {
      $expires = self::LIFETIME;
    }

    global $wpdb;

    $sql = $wpdb->prepare(
      "INSERT INTO `%1\$s` (`key`, `data`, `expires`) VALUES ('%2\$s', '%3\$s', %4\$d) ON DUPLICATE KEY UPDATE `data` = '%3\$s', `expires` = %4\$d",
      $wpdb->prefix . self::TABLE_NAME,
      self::createKey($key),
      serialize($data),
      time() + intval($expires)
    );

    return (bool) $wpdb->query($sql);
  }

  /**
   * Retrieves cache entry. If it's expired - it'll be removed and false will be returned.
   * @param  string $key Key used to retrieve data.
   * @return mixed Data retrieved from cache. False instead.
   * @uses   self::TABLE_NAME
   * @uses   self::createKey()
   * @see    self::set()
   * @see    self::delete()
   */
  public static function get($key) {
    if (!isset($key) || empty($key)) {
      return false;
    }

    global $wpdb;

    $item = $wpdb->get_row(
      $wpdb->prepare(
        "SELECT * FROM `%1\$s` WHERE `key` = '%2\$s' LIMIT 1",
        $wpdb->prefix . self::TABLE_NAME,
        self::createKey($key)
      )
    );

    if (is_null($item)) {
      return false;
    }

    if ($item->expires < time()) {
      self::delete($key);
      return false;
    }

    return unserialize($item->data);
  }

  /**
   * Removes cache entry.
   * @param  string $key Key used to remove data.
   * @return bool True if cache entry was removed. False otherwise.
   * @uses   self::TABLE_NAME
   * @uses   self::createKey()
   */
  public static function delete($key) {
    if (!isset($key) || empty($key)) {
      return false;
    }

    global $wpdb;

    return (bool) $wpdb->delete(
      $wpdb->prefix . self::TABLE_NAME,
      ['key' => self::createKey($key)],
      ['%s']
    );
  }

  public static function deleteByKeySuffix(string $keySuffix) {
    if (empty($keySuffix)) {
      return false;
    }

    $keySuffix = '%' . $keySuffix;

    /* @var $wpdb \wpdb */
    global $wpdb;

    $sql = $wpdb->prepare(
        "DELETE FROM `" . $wpdb->prefix . self::TABLE_NAME . "` WHERE `key` LIKE %s",
        [
          $keySuffix
        ]
    );

    return (bool) $wpdb->query($sql);
  }
}
