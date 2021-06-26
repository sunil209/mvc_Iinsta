<?php
namespace Instapage\Classes\Cache\Handler;

use \Instapage\{
  Classes\Cache\CacheInterface,
  Helpers\StringHelper,
  Classes\Environment
};

/**
 * Memcache cache handler.
 */
class Memcache implements CacheInterface {
  /**
   * @var string Host used to connect to Memcached
   */
  const HOST = '127.0.0.1';

  /**
   * @var int Port used to connect to Memcached
   */
  const PORT = 11211;

  /**
   * @var string Cache key prefix.
   */
  const KEY_PREFIX = 'cache_memcache_';

  /**
   * @var int Cache entry default lifetime
   */
  const LIFETIME = 3600;

  /**
   *
   * @var \Memcached Memcached PHP extension object
   */
  private static $handle = null;

  private static $serverAddresses = [];

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
   * Get proper memcache server IPs relevant to environement.
   * Diffrent servers on live, diffrent on uat
   *
   * @return array
   */
  public static function getProperMemcacheServersIPs() : array {
    if (!empty(self::$serverAddresses)) {
      return self::$serverAddresses;
    }

    $environment = new Environment($_SERVER);

    // default Addresses of memcache server
    $serverAddresses = [
       self::HOST
    ];

    if ($environment->isItUAT()) {
      $serverAddresses = array_values(Environment::UAT_IPs);
    } else if ($environment->isItLive()) {
      $serverAddresses = array_values(Environment::LIVE_IPs);
    }

    return self::$serverAddresses = $serverAddresses;
  }

  /**
   * Init method used to create necessary database table.
   * @return bool True if initialization was successful. False otherwise
   * @uses   self::HOST
   * @uses   self::PORT
   * @uses   self::$handle
   */
  public static function init() {
    if (!extension_loaded('memcached')) {
      return false;
    }

    self::$handle = new \Memcached();

    return self::addServers();
  }

  /**
   * Get array containg IPs of connected memcache servers
   *
   * @return array
   */
  public static function getConnectedServersIPs() : array {
    $serverList = self::$handle->getServerList();
    return array_column($serverList, 'host');
  }

  /**
   * Check which server from given array of servers ip is not connected
   *
   * @param array $wantedMemcacheServersPoolIPs Array containing traget memcache servers IPs, ['10.128.0.6', '10.128.0.7', ...]
   * @return array Array containing servers IP from $wantedMemcacheServersPoolIPs which are not yet connected
   */
  public static function getNotConnectedServersIPs(array $wantedMemcacheServersPoolIPs) : array {
    return array_diff($wantedMemcacheServersPoolIPs, self::getConnectedServersIPs());
  }

  /**
   * Add wanted servers to the pool
   *
   * @return type
   */
  public static function addServers() {
    $memcacheServersIPs = self::getProperMemcacheServersIPs();
    $notConnectedServersIPs = self::getNotConnectedServersIPs($memcacheServersIPs);

    $serversPoolToConnect = array_map(function ($serverIP) {
      return [$serverIP, self::PORT];
    }, $notConnectedServersIPs);

    return self::$handle->addServers($serversPoolToConnect);
  }

  /**
   * Creates cache entry. If $key was used before - it'll be overwritten.
   * @param  string $key Key used to store data under.
   * @param  mixed $data Data to be stored. It could be simple type, an array or an object.
   * @param  int $expires Cache expiration in seconds.
   * @return bool True if data are stored in the cache. False instead.
   * @uses   self::LIFETIME
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

    return self::$handle->set(
      self::createKey($key),
      serialize($data),
      time() + intval($expires)
    );
  }

  /**
   * Retrieves cache entry. If it's expired - it'll be removed and false will be returned.
   * @param  string $key Key used to retrieve data.
   * @return mixed Data retrieved from cache. False instead.
   * @uses   self::handle
   * @uses   self::createKey()
   * @see    self::set()
   * @see    self::delete()
   */
  public static function get($key) {
    if (!isset($key) || empty($key)) {
      return false;
    }

    $item = self::$handle->get(self::createKey($key));

    if (!$item) {
      return false;
    }

    return unserialize($item);
  }

  /**
   * Removes cache entry.
   * @param  string $key Key used to remove data.
   * @return bool True if cache entry was removed. False otherwise.
   * @uses   self::handle
   * @uses   self::createKey()
   */
  public static function delete($key) {
    if (!isset($key) || empty($key)) {
      return false;
    }

    return self::$handle->delete(self::createKey($key));
  }

  /**
   * Gets the keys stored on all the servers
   *
   * @return array
   */
  protected static function getAllKeys() : array {
    $keysOfObjectsStoredInMemcache = self::$handle->getAllKeys();

    // on failure memcache return false
    if ($keysOfObjectsStoredInMemcache === false) {
      return [];
    }

    // casting because here can be only string, so cast it to array to use in foreach
    return (array) $keysOfObjectsStoredInMemcache;
  }

  public static function deleteByKeySuffix(string $keySuffix) {
    $keysOfObjectsStoredInMemcache = self::getAllKeys();
    $keysToDelete = [];

    foreach ($keysOfObjectsStoredInMemcache as $key) {
      if (StringHelper::checkIfStringHasSuffix($key, $keySuffix)) {
        $keysToDelete[] = $key;
      }
    }

    self::$handle->deleteMulti($keysToDelete);
  }
}
