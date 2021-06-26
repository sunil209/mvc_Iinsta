<?php

namespace Instapage\Classes\InstaPerformance;

use Instapage\Classes\InstaPerformance\{
  TimePoint,
  TimeSegmentInterface
};

/**
 * Single time segment, represent performance measurement of code segment executed once.
 */
class SingleTimeSegment implements TimeSegmentInterface {
  /**
   * @var TimePoint
   */
  protected $startPoint;
  /**
   *
   * @var TimePoint
   */
  protected $endPoint;

  /**
   * @var string $segmentLabel
   */
  protected $segmentLabel;

  public function __construct(string $segmentLabel) {
    $this->segmentLabel = $segmentLabel;
    $this->startPoint = new TimePoint();
  }

  public function stop() {
    $this->endPoint = new TimePoint();
  }

  public function getLabel() : string {
    return $this->segmentLabel;
  }

  /**
   * Check if segment has stop point created.
   *
   * @return bool
   */
  public function isEnded() : bool {
    return isset($this->endPoint) && $this->endPoint instanceof \Instapage\Classes\InstaPerformance\TimePoint;
  }

  /**
   * Get elapsed time durign stop and start point.
   *
   * @return float
   * @throws \Exception
   */
  public function getDuration() : float {
    if (!$this->isEnded()) {
      throw new \Exception('Time segment with label "' . $this->segmentLabel . '" was not ended');
    }

    return $this->endPoint->getTime() - $this->startPoint->getTime();
  }
}
