<?php
namespace Instapage\Helpers;

use Instapage\Classes\Data;

class AnalyticsHelper {

  /**
   * Returns a Google Analytics ClientId.timestamp pair
   * 
   * @return string|null Google Analytics ClientId.timestamp pair or null, if no _ga cookie is present.
   */
  public static function getGoogleAnalyticsClientId() {
    $gaCookie = Data::_cookie('_ga', null);
    if (empty($gaCookie)) {
      return null;
    }

    return implode('.', array_slice(explode('.', $gaCookie), 2));
  }
}
