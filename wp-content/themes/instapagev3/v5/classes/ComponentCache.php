<?php

namespace Instapage\Classes;

use \Instapage\Classes\Cache\CacheInterface;

/**
 * Class holding component's cache functionality
 */
class ComponentCache {
  /**
   * Method use to hook in all needed action for proper component's cache work
   */
  public static function hookClearingCache() : void {
    add_action('save_post', [__CLASS__, 'clearCacheOnPostSave'], 10, 3);
  }

  /**
   * Generate key suffix associated with object id.
   *
   * It is useful to connect component's cache with posts, to clear them only if proper post is updated.
   *
   * @param int $id
   * @return string
   */
  public static function keySuffixAssociatedWithObjectID(?int $id) : string {
    if ($id === null) {
      return '';
    }

    return '_objectid' . $id;
  }

  /**
   * Key for component's cache which should be deleted on every save.
   *
   * For example on blog listing this is used, as content is changed.
   *
   * @return string
   */
  public static function keySuffixForDeletingOnAnySave() : string {
    return '_deleteonanysave';
  }

/**
 * Clear rendered component's cache after post is save
 *
 * @param int $postID  The post ID.
 * @param \WP_Post $post   The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */
  public static function clearCacheOnPostSave(int $postID, \WP_Post $post, bool $update) : void {
    if ($update) {
      $cache = \Instapage\Classes\Factory::getCache();
      self::clearCacheForComponentsAssociatedWithPost($post->ID, $cache);
      self::clearCacheForComponentsWhichNeedToBeRefreshedOnEverySave($cache);
    }
  }

  /**
   * Clear component's cache those who was rendered based on data from this post
   *
   * @param int $postID
   * @param string $cacheClassName
   */
  protected static function clearCacheForComponentsAssociatedWithPost(int $postID, string $cacheClassName) {
    $keySuffix = self::keySuffixAssociatedWithObjectID($postID);
    $cacheClassName::deleteByKeySuffix($keySuffix);
  }

  /**
   * Clear components cache which have to be re render on every resave post.
   *
   * @param string $cacheClassName
   */
  protected static function clearCacheForComponentsWhichNeedToBeRefreshedOnEverySave(string $cacheClassName) {
    $keySuffix = self::keySuffixForDeletingOnAnySave();
    $cacheClassName::deleteByKeySuffix($keySuffix);
  }
}
