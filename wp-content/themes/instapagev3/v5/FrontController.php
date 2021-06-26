<?php
namespace Instapage;

use \Instapage\Helpers\StringHelper;

class FrontController {

  private $dispatcher = null;

  //Not typical page/post
  public $pages = [
    'search',
    '404',
    'amp',
    'custom-sitemap',
    'single-template-page'
  ];

  public function __construct() {
    try {
      $this->loadDispatcher();
    } catch(\Exception $e) {
      if (defined('WP_DEBUG') && WP_DEBUG) {
        echo $e->getMessage();
      } else {
        error_log($e->getMessage());
      }
    }
  }

  private function loadDispatcher() {
    global $post;
    
    // Array of possible dispatchers
    $dispatcherClasses = [];
    $page = getV5Page();

    if (in_array($page, $this->pages)) {
      $name = $page === '404' ? 'Error404' : $page;
      $dispatcherClasses[] = '\\Instapage\\Dispatchers\\' . StringHelper::toStudlyCaps($name) . 'Dispatcher';
    } else {
      // Match by post type
      $postType = $post->post_type;
      
      $dispatcherClasses[] = '\\Instapage\\Dispatchers\\' . StringHelper::toStudlyCaps($postType) . 'Dispatcher';

      // Match by post name
      $postName = $post->post_name;
      $dispatcherClasses[] = '\\Instapage\\Dispatchers\\' . StringHelper::toStudlyCaps($postName) . 'Dispatcher';
    }

    foreach ($dispatcherClasses as $dispatcherClass) {
      if (class_exists($dispatcherClass)) {
        $this->dispatcher = new $dispatcherClass();
        break;
      }
    }

    //throw new \Exception('Can\'t load dispatcher class (' . $dispatcherClass . ') .');
  }
}
