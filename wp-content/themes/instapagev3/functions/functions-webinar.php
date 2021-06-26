<?php

use Instapage\Helpers\StringHelper;

add_filter('post_type_link', ['Webinar', 'getPermalink'], 10, 2);

class Webinar extends CustomPostType {
  public static $postType = 'webinar';
  public static $nameSingular = 'webinar';
  public static $namePlural = 'webinars';
  public static $slug = 'webinars';
  public static $hasArchive = true;

  public static function isWebinar($post = null) {
    return parent::is(null, $post);
  }

  public static function getPermalink($url, $post) {
    if (!self::isWebinar($post)) {
      return $url;
    }

    $webinarUrlACF = trim(get_field('webinar_url', $post));
    $fullWebinarURL = StringHelper::parseToFullURL($webinarUrlACF);

    if (empty($fullWebinarURL)) {
      return $url;
    }

    return $fullWebinarURL;
  }
}
new Webinar();
