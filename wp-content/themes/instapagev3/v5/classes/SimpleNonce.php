<?php
namespace Instapage\Classes;

/**
 * Replacement class for native Wordpress nonces implementation
 */
class SimpleNonce {
  /**
   * @var int NONCE_LIFETIME Lifetime of nonces in seconds
   */
  const NONCE_LIFETIME = 3600;

  /**
   * Creates required database structure, if needed
   * @return void
   */
  public static function init() {
    global $wpdb;

    $result = $wpdb->get_row("SHOW TABLES LIKE '{$wpdb->prefix}smpnnc'", ARRAY_A);

    if ($result) {
      return true;
    }

    $wpdb->query("
      CREATE TABLE `wp_smpnnc` (
        `name` VARCHAR(150) NOT NULL COLLATE 'ascii_general_ci',
        `value` VARCHAR(32) NOT NULL COLLATE 'ascii_general_ci',
        `expires` INT(11) UNSIGNED NOT NULL,
        PRIMARY KEY (`name`)
      )
      COLLATE='ascii_general_ci' ENGINE=InnoDB
    ");
  }

  /**
   * Creates nonce
   * @param  string $name Nonce name
   * @uses   self::generateID()
   * @uses   self::storeNonce()
   * @return array Nonce details
   */
  public static function createNonce($name) {
    if (is_array($name)) {
      $name = (isset($name['name'])) ? $name['name'] : 'nonce';
    }

    $id = self::generateID();
    $name = substr($name, 0, 17) . '_' . $id;
    $nonce = md5(wp_salt('nonce') . $name . microtime(true));
    self::storeNonce($nonce, $name);

    return ['name'=> $name, 'value'=> $nonce];
  }

  /**
   * Creates nonce
   * @param  string $name Nonce name
   * @uses   self::createNonce()
   * @return string Nonce HTML field
   */
  public static function createNonceField($name = 'nonce') {
    if (is_array($name)) {
      $name = (isset($name['name'])) ? $name['name'] : 'nonce';
    }

    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $nonce = self::createNonce($name);
    $nonce['noncePlainName'] = $name;

    return $nonce;
  }
  
  /**
   * Check if nonce is properly formatted.
   * 
   * We assume that nonce is properly formated when it has non empty value and name key.
   * And that value contain 32 characters string [length of md5 hash]
   * 
   * @param array $nonce
   * @return boolean
   */
  public static function checkIsNonceProperlyFormatted($nonce) {
    // we know that $nonce['value'] is md5 hash, so we're checking length of string
    // every md5 hash has 32 characters
    return 
      !empty($nonce['value']) 
      && !empty($nonce['name'])
      && strlen($nonce['value']) === 32;
  }
  
  /**
   * Method for outputing html code for nonce.
   * 
   * When you pass as a second parameter false, string will be returned.
   * 
   * @param array $nonce
   * @return string|null Return string with html nonce or echo it. 
   */
  public static function nonceView($nonce, $echo = true) {
    
    $html = '<input type="hidden" name="' . $nonce['name'] . '" value="' . $nonce['value'] . '">' .
            '<input type="hidden" name="' . $nonce['noncePlainName'] . '" value="' . $nonce['name'] . '">';
  
    if ($echo) {
      echo $html;
    } else {
      return $html;
    }
  }

  /**
   * @param  string $name Nonce name
   * @param  string $value Expected value
   * @uses   self::fetchNonce()
   * @return bool True if nonce matches expected value, false otherwise
   */
  public static function checkNonce($name, $value) {
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    if (!self::checkIsNonceProperlyFormatted(['name' => $name, 'value' => $value])) {
      return false;
    }

    $nonce = self::fetchNonce($name);

    return ($nonce === $value);
  }

  /**
   * Stores nonce in database
   * @param  array $nonce Nonce
   * @param  string $name Nonce name
   * @uses   self::NONCE_NAME_PREFIX
   * @uses   self::NONCE_LIFETIME
   * @return bool True if nonce was stored, false otherwise
   */
  public static function storeNonce($nonce, $name) {
    global $wpdb;

    if (empty($name)) {
      return false;
    }

    $wpdb->insert(
      $wpdb->prefix . 'smpnnc',
      [
        'name' => $name,
        'value' => $nonce,
        'expires' => time() + self::NONCE_LIFETIME
      ],
      [
        '%s',
        '%s',
        '%d'
      ]
    );

    return true;
  }

  /**
   * Removes single nonce from database
   * @param  string $name Nonce name
   * @uses   self::NONCE_NAME_PREFIX
   * @return bool True if nonce was removed, false otherwise
   */
  public static function deleteNonce($name) {
    global $wpdb;

    return (bool) $wpdb->delete($wpdb->prefix . 'smpnnc', ['name' => $name], ['%s']);
  }

  /**
   * Removes multiple/all nonces from database
   * @param  bool $force Whether to force removal no matter the lifetime
   * @uses   self::NONCE_NAME_PREFIX
   * @uses   self::NONCE_LIFETIME
   * @uses   self::deleteNonce()
   * @return int Number of removed nonces
   */
  public static function clearNonces($force = false) {
    global $wpdb;

    if (defined('WP_SETUP_CONFIG') || defined('WP_INSTALLING')) {
      return;
    }

    $rows = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}smpnnc`");
    $noncesDeleted = 0;

    foreach ($rows as $singleNonce) {
      if ($force || ($singleNonce->expires < time())) {
        $noncesDeleted += (self::deleteNonce($singleNonce->name) ? 1 : 0);
      }
    }

    return (int) $noncesDeleted;
  }

  /**
   * @param  string $name Nonce name
   * @uses   self::NONCE_NAME_PREFIX
   * @uses   self::deleteNonce()
   * @return mixed
   */
  protected static function fetchNonce($name) {
    global $wpdb;

    $nonce = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}smpnnc` WHERE `name` = '{$name}'", ARRAY_A);
    if (!is_null($nonce)) {
      self::deleteNonce($name);

      if ($nonce['expires'] < time()) {
        return null;
      }

      return $nonce['value'];
    }

    return null;
  }

  /**
   * @return string Hash
   */
  protected static function generateID() {
    require_once(ABSPATH . 'wp-includes/class-phpass.php');
    $hasher = new \PasswordHash(8, false);
    return md5($hasher->get_random_bytes(100, false));
  }
}
