<?php

namespace Instapage\Classes\InstaPerformance;

/**
 * The smallest part of InstaPerformance package.
 * Class represents single point in code execution,
 * it save memory usage and current time.
 */
class TimePoint {
  private $time;
  private $memory;

  public function __construct() {
    // get current value of memory used and current time
    $this->time = microtime(true);
    $this->memory = memory_get_usage(true);
  }

  public function getTime() : float {
    return $this->time;
  }

  public function getMemory() : float {
    return $this->memory;
  }
}
