<?php
namespace Instapage\Classes\AbTesting;

use \Instapage\Helpers\PreWpHelper;

/**
 * Class to store information about experiment variation.
 * 
 * Caution! Class is used before initialization of WP, so using WP functions is prohibited here! Use \Instapage\Helpers\PreWpHelper instead.
 */
class Variation {
  /**
   * @var int $id ID of the variation. Should be greater than 0 (0 is for the original path of the experiment).
   */
  public $id = null;

  /**
   * @var string $redirectPath Redirect path of the variation.
   */
  public $redirectPath = null;

  /**
   * @var float $trafficSplitRatio Float value between 0 and 1, indicates how much traffic should be assigned to a specific variation. 
   */
  public $trafficSplitRatio = 0;
  
  /**
   * Cerates a specific variation.
   * 
   * @param string $id ID of the variation. Must be greater than 0.
   * @param string $redirectPath Redirect path of the variation.
   * @param float  $trafficSplitRatio Float value between 0 and 1, indicates how much traffic should be picked for a specific variation.
   * 
   * @throws Exception When either traffic split ratio isn't between 0.0 and 1.0 or variation ID if less than 1.
   * 
   * @return void
   */
  public function __construct(int $id, string $redirectPath, float $trafficSplitRatio) {
    if ($trafficSplitRatio < 0 || $trafficSplitRatio > 1) {
      throw new \Exception('Traffic split ratio in variation ' . $id . ' should have a value between 0 and 1');
    }

    if ($id < 1) {
      throw new \Exception('Variation IDs should start with 1. 0 is for the original URL.');
    }

    $this->id                = $id;
    $this->redirectPath      = $redirectPath;
    $this->trafficSplitRatio = $trafficSplitRatio;
  }

  /**
   * Returns current variation URL.
   * 
   * @return string Variation URL.
   */
  public function getRedirectUrl() {
    return PreWpHelper::getSiteUrl() . $this->redirectPath;
  }
}
