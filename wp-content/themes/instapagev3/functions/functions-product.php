<?php
class Product extends CustomPostType {
  public static $postType = 'product';
  public static $nameSingular = 'product';
  public static $namePlural = 'products';
  public static $slug = 'products';
  public static $hasArchive = false;
  public static $pages = false;

  public static function isProduct($post = null) {
    return parent::is(null, $post);
  }
}
new Product();
