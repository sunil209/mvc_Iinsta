<?php
namespace Instapage\Traits;

trait ExternalJSON {
  public static function fetchUrl($url) {
    if (empty($url)) {
      throw new \Exception(__('Url cannot be empty'));
    }

    $data = \wp_remote_get($url);
    if (\is_wp_error($data)) {
      throw new \Exception(__('Cannot fetch file from given url'));
    }

    return $data['body'];
  }

  public static function parseJSON($data) {
    if (empty($data)) {
      throw new \Exception(__('Data cannot be empty'));
    }

    $json = json_decode($data);
    if (is_null($json)) {
      throw new \Exception(__('Data cannot be parsed as valid JSON'));
    }

    return $json;
  }

  public static function fetchJson($url) {
    try {
      $data = self::fetchUrl($url);
      $json = self::parseJSON($data);
      return $json;
    }
    catch (\Exception $e) {
      throw $e;
    }
  }
}
