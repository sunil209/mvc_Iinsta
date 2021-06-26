<?php
namespace Instapage\Classes;

use \Instapage\Classes\SimpleNonce;

/**
 * Class for simple nonce ajax endpoint handling
 */
class SimpleNonceAjax {
    
  /**
   * Activate simple nonce API endpoint and do all initializaiton stuff. 
   * 
   * @return void
   */
  public static function init() {
    add_action('wp_ajax_nopriv_simple_nonce_ajax_get_nonce', [SimpleNonceAjax::class, 'getNonce']);
    add_action('wp_ajax_simple_nonce_ajax_get_nonce', [SimpleNonceAjax::class, 'getNonce']);
  }
  
  /**
   * Get nonce based on nonceName from POST AJAX request.
   * 
   * It returnes json with status in response.data.status which can be 'notverified' or 'verified'
   * and payload as a nonce html in response.data.payload when status is verified.
   * 
   * @return void
   */
  public static function getNonce() {
    $nonceName = filter_input(INPUT_POST, 'nonceName', FILTER_SANITIZE_STRING);
    
    $response = [
        'status' => 'notverified',
        'payload' => ''
    ];
    
    $nonce = SimpleNonce::createNonceField($nonceName);
    // check if returned $nonce has proper format
    if (SimpleNonce::checkIsNonceProperlyFormatted($nonce)) {
      $nonceHTML = SimpleNonce::nonceView($nonce, $echo = false);
      
      $response = [
          'status' => 'verified',
          'payload' => $nonceHTML
      ];
    }
    
    wp_send_json_success($response);
  }
}
