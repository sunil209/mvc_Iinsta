<?php

namespace Instapage\Classes\InstaPerformance;

use Instapage\Classes\InstaPerformance\{
  SingleTimeSegment,
  TimeSegmentInterface
};

/**
 * Looped times segment aggregate Single Time Segment - used in all kind of loops.
 *
 * @author konrad-stalega
 */
class LoopedTimeSegment implements TimeSegmentInterface {
  /**
   * @var string $segmentLabel
   */
  protected $segmentLabel;

  /**
   * @var TimeSegmentInterfaces[] $timeSegments
   */
  protected $loopedTimeSegments = [];

  public function __construct(SingleTimeSegment $firstTimeSegmentInTheLoop) {
    $this->segmentLabel = $firstTimeSegmentInTheLoop->getLabel();
    $this->add($firstTimeSegmentInTheLoop);
  }

  /**
   * Add single time segment to looped time segment, used internally by instaperformance.
   *
   * @param SingleTimeSegment $firstTimeSegmentInTheLoop
   */
  public function add(SingleTimeSegment $firstTimeSegmentInTheLoop) : void {
    $this->loopedTimeSegments[] = $firstTimeSegmentInTheLoop;
  }

  protected function getRecentTimeSegment() : SingleTimeSegment {
    $recentTimeSegment = end($this->loopedTimeSegments);
    reset($this->loopedTimeSegments);

    return $recentTimeSegment;
  }

  /*
   * Stops latest time segment in loopedTimeSegment container
   *
   * @return void
   */
  public function stop() : void {
    $this->getRecentTimeSegment()->stop();
  }

  /**
   * Check if looped time segment is ended. The last single time segment is checked.
   *
   * @return bool
   */
  public function isEnded() : bool {
    return $this->getRecentTimeSegment()->isEnded();
  }

  /**
   * Get array of singleTimeSegments aggregated by this loopedTimeSegment.
   *
   * @return array
   */
  public function getLoopedTimeSegmentsCollection() : array {
    return $this->loopedTimeSegments;
  }

  /**
   * Get label of looped time segment - each single time segment has the same label
   *
   * @return string
   */
  public function getLabel() : string {
    return $this->segmentLabel;
  }
}
