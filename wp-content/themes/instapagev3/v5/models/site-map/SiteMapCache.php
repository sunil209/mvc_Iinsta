<?php
namespace Instapage\Models\SiteMap;

use \Instapage\Models\SiteMap;
use \Instapage\Classes\Factory;

/**
 * Class handling HTML site maps cache
 */
class SiteMapCache {

  /**
   * @var integer Cache lifetime in seconds. Zero means never expire.
   *              Any time higher than 30 days in memcache is interpreted as a unix
   *              timestamp date.
   *
   *              We set it for 30 days => 30 * 24 * 60 * 60 [s],
   *              But in PHP lower than 5.6 we cannot use multiply in const, so we save in const result
   */
  const LIFETIME = 2592000;

  /**
   * @var string Cache key for storing sitemap
   */
  const CACHE_KEY = 'html_sitemap';

  /**
   * Get sitemap key for cache handling purpose
   *
   * @uses self::CACHE_KEY
   *
   * @return string Cache key for html sitemap
   */
  protected static function getSiteMapCacheKey() {
    return self::CACHE_KEY;
  }

  /**
   * Get sitemap from cache
   *
   * @uses  self::getSiteMapCacheKey()
   * @uses  \Instapage\Classes\Factory::getCache()
   *
   * @return SiteMapSection[]|bool Return sitemap from cache or false when cache is empty
   */
  public static function getHtmlSiteMap() {
    $cache = Factory::getCache();
    $cacheKey = self::getSiteMapCacheKey();

    return $cache::get($cacheKey);
  }

  /**
   * Store sitemap in cache
   *
   * @param SiteMapSection[] $htmlSiteMap An array with sitemap to store in cache
   *
   * @uses  self::getSiteMapCacheKey()
   * @uses  \Instapage\Classes\Factory::getCache()
   *
   * @return bool True if data are stored in the cache. False instead.
   *
   */
  public static function storeHtmlSiteMap($htmlSiteMap) {
    $cache = Factory::getCache();
    $cacheKey = self::getSiteMapCacheKey();

    return $cache::set($cacheKey, $htmlSiteMap, SiteMapCache::LIFETIME);
  }

  /**
   * Delete sitemap from cache
   *
   * @uses  self::getSiteMapCacheKey()
   * @uses  \Instapage\Classes\Factory::getCache()
   *
   * @return bool True if sitemap was removed from cache. False otherwise.
   *
   */
  public static function deleteHtmlSiteMapFromCache() {
    $cache = Factory::getCache();
    $cacheKey = self::getSiteMapCacheKey();
    return $cache::delete($cacheKey);
  }
}
