<?php

namespace Instapage\Classes\InstaPerformance;

/**
 * Interface which must implements all StatisticStorages
 */
interface StatisticStorageInterface {
  public function write(array $statisticData);
  public function read();
}
