<?php

namespace Instapage\Classes;

use Instapage\Classes\DashboardEnhancers;

/**
 * This class encapsulate all wordpress admin dashboard enhancements and cusotmizations
 */
class DashboardEnhancer {
  use \Instapage\Traits\Singleton;

  /**
   * @var boolean Does our dashboard was enhanced and customizated?
   */
  protected $enhanced = false;


  /**
   * Make all needed enhancement for wordpress admin dashboard.
   */
  public function enhance() : void {
    if (!$this->enhanced) {
      DashboardEnhancers\postsReorder::getInstance()->enhance();
      $this->enhanced = true;
    }
  }

}
