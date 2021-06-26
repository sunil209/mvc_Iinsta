<?php
class Video extends CustomPostType {
  public static $postType = 'video';
  public static $nameSingular = 'video';
  public static $namePlural = 'videos';
  public static $slug = 'videos';
  public static $hasArchive = true;
  public static $pages = true;

  public static function isVideo($post = null) {
    return parent::is(null, $post);
  }
}
new Video();
