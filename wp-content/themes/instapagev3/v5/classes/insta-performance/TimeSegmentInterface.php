<?php

namespace Instapage\Classes\InstaPerformance;

/**
 * All times segment types must implements this methods.
 */
interface TimeSegmentInterface {
  public function stop();
  public function isEnded() : bool;
  public function getLabel() : string;
}
