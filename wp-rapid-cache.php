<?php

require_once(__DIR__ . '/wp-rapid-cache-key-generator.php');

/**
 * Class responsible for storing generated HTML by using 'memcached' service.
 */
class RapidCache {
  /**
   * @var int Cache liferime.
   */
  public $cacheLifetime = 60;

  /**
   * @var An array containing request patterns. If a request matches the pattern, the result HTML won't be cached.
   */
  public $cachePatternsBlackList = [
    '\/wp-admin\/',
    '\/wp-login'
  ];

  /**
   * @var object Main object of 'memcached' service.
   */
  protected $memcache = false;

  /**
   * Constructor.
   */
  public function __construct() {
    $this->timer = microtime(true);
  }

  /**
   * Gets the stored HTML from 'memcached' service.
   *
   * @return mixed Retrieved HTML as a string or false, if no cache is present or error occured.
   */
  public function getContents() {
    if (
      !$this->isCacheable() ||
      !$this->getMemcache()
    ) {
      return false;
    }

    $contents = $this->getMemcache()->get($this->getKey());

    if ($contents) {
      $contents .= sprintf('<!-- Cache generated in %s seconds. -->', $this->getGenerationTime());
    }

    return $contents;
  }

  /**
   * Generated a key for cache object.
   *
   * @return string Cache key.
   */
  public function getKey() {
    return (new RapidCacheKeyGenerator())->getKeyBasedOnUrl($_SERVER['REQUEST_URI']);
  }

  /**
   * Tries to connect with 'memcached' service ant returns new object on success.
   *
   * @return object Memcached object.
   */
  public function getMemcache() {
    if ($this->memcache === false) {
      $this->memcache = new Memcache();

      try {
        if (!$this->memcache->connect('localhost', 11211)) {
          throw new Exception('Could not connect memcache server');
        }
      } catch (Exception $e) {
        $this->memcache = false;
      }
    }

    return $this->memcache;
  }

  /**
   * Decides if current request should be stored in cache.
   *
   * @return boolean Decision if a result of current request should be stored.
   */
  public function isCacheable() {
    if (
      $_SERVER['REQUEST_METHOD'] !== 'GET' ||
      !empty($_GET['preview'])
    ) {
      return false;
    }

    foreach ($this->cachePatternsBlackList as $pattern) {
      if (preg_match('/' . $pattern . '/i', $_SERVER['REQUEST_URI'])) {
        return false;
      }
    }

    return true;
  }

  /**
   * Check if generated request should be written to cache?
   */
  private function shouldBeSavedToCache() : bool {
    $post = get_post();
    // if this is password protected page do not store it in the cache
    return empty($post->post_password);
  }

  /**
   * Stores generated HTML in 'memcached' service.
   */
  public function saveContents($contents) {
    if (function_exists('is_user_logged_in') && is_user_logged_in()) {
      return false;
    }

    $contents .= sprintf('<!-- Original generated in %s seconds. -->', $this->getGenerationTime());

    if ($this->getMemcache() && $this->isCacheable() && $this->shouldBeSavedToCache()) {
      $this->getMemcache()->set($this->getKey(), $contents, false, time() + $this->cacheLifetime);
    }
  }

  /**
   * Returns the time of cache generation in seconds.
   *
   * @return float Time of cache generation in seconds.
   */
  public function getGenerationTime() {
    return round(1000 * (microtime(true) - $this->timer), 2) / 1000;
  }
}
