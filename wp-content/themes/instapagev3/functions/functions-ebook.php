<?php
add_filter('post_type', ['Ebook', 'getPermalink'], 10, 2);
add_filter('post_type_link', ['Ebook', 'getPermalink'], 10, 2);

class Ebook extends CustomPostType {
  public static $postType = 'ebook';
  public static $nameSingular = 'ebook';
  public static $namePlural = 'ebooks';
  public static $slug = 'ebooks';
  public static $hasArchive = true;
  public static $pages = true;

  public static function isEbook($post = null) {
    return parent::is(null, $post);
  }

  public static function getPermalink($url, $post) {

    if (self::isEbook($post)) {
      $ebookUrl = get_field('e_book_url', $post);

      return $ebookUrl;
    }

    return $url;
  }
}

new Ebook();
