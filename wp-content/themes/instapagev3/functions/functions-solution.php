<?php
class Solution extends CustomPostType {
  public static $postType = 'solution';
  public static $nameSingular = 'solution';
  public static $namePlural = 'solutions';
  public static $slug = 'solutions';
  public static $hasArchive = false;
  public static $pages = false;

  public static function isSolution($post = null) {
    return parent::is(null, $post);
  }
}
new Solution();
