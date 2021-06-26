<?php

namespace Instapage\Classes\InstaPerformance;

use Instapage\Classes\InstaPerformance\{
  TimeSegmentInterface,
  LoopedTimeSegment,
  SingleTimeSegment,
  Configuration,
  Math
};


/**
 * Statistic handler class is responsible for all calculation related to instaPerformance test.
 *
 */
class StatisticHandler {

  /**
   *
   * @var TimeSegmentInterfaces[] $timeSegments Collected time segments during the current requests.
   *                                            All objects here implements TimeSegmentInterfaces.
   *                                            Key is equal to time segment label, value to object implementing TimeSegmentInterface.
   */
  private $timeSegments;

  /**
   * Statistic date for timeSegments during current request.
   *
   * @var array
   */
  private $statisticDataForRequest = [];

  /**
   * Statistic date for timeSegments during current request and earlier requests if test over request is set.
   *
   * @var array
   */
  private $statisticData = [];

  /**
   * Statistic date earlier requests if test over request is set.
   *
   * @var array
   */
  private $statisticsFromWholeTestSet = [];

  /**
   * @var Configuration
   */
  private $ipConfiguration;

  public function __construct(Configuration $instaPerformanceConfiguration, $statisticFromWholeTestSet = [], TimeSegmentInterface ...$timeSegments) {
    $this->statisticsFromWholeTestSet = $statisticFromWholeTestSet;
    $this->ipConfiguration = $instaPerformanceConfiguration;
    $this->timeSegments = $timeSegments;

    $this->calculateStatisticsForRequest();
    $this->statisticData = array_merge_recursive($this->statisticsFromWholeTestSet, $this->statisticDataForRequest);

    if ($this->ipConfiguration->isTestOverRequestEnabled()) {
      $this->calculateOverRequestStatistics();
    }
  }

  /**
   * Calculate statistics over request for given time segment
   *
   * @param array $timeSegments
   * @return array $stats Array with stats
   */
  private function calculateOverRequestStatisticsForTimeSegment(array $timeSegments) {
    $durations = [];
    foreach ($timeSegments as $key => $request) {
      if ($key === 'stats') {
        continue;
      }

      if (!empty($request['duration'])) {
        $durations[] = $request['duration'];
      } else if (!empty($request['average'])) {
        $durations[] = $request['average'];
      }
    }


    $stats = $this->calculateStatisticBasedOnDurations($durations);

    return $stats;
  }

  /**
   * Entry point for calculating statistics for test over request.
   *
   * @return void
   */
  private function calculateOverRequestStatistics() : void {
    foreach ($this->statisticData as $segmentLabel => $timeSegment) {
      $stats = $this->calculateOverRequestStatisticsForTimeSegment($timeSegment);
      $this->statisticData[$segmentLabel]['stats'] = $stats;
    }
  }

  /**
   * Get final result of Statistic Handler work.
   *
   * @return array
   */
  public function getStatistics() {
    return $this->statisticData;
  }

  /**
   * Calculate set of statistic based on array with duration times
   *
   * @param array $durationTimes
   * @return array
   */
  private function calculateStatisticBasedOnDurations(array $durationTimes) {
    $average = Math::average($durationTimes);
    $min = Math::min($durationTimes);
    $max = Math::max($durationTimes);
    $stdDev = Math::stdDev($durationTimes);

    return [
      'average' => $average,
      'min' => $min,
      'max' => $max,
      'stdDev' => $stdDev
    ];
  }

  /**
   * Calculate statisc for looped times segment during currrent request.
   *
   * @param LoopedTimeSegment $timeSegment
   * @return array
   */
  private function calculateStatisticForLoopedTimeSegment(LoopedTimeSegment $timeSegment) : array {
    $loopedTimeSegment = $timeSegment->getLoopedTimeSegmentsCollection();
    $loopCount = count($loopedTimeSegment);
    $durationTimes = [];

    foreach ($loopedTimeSegment as $singleTimeSegment) {
      $durationTimes[] = $singleTimeSegment->getDuration();
    }

    $stats = $this->calculateStatisticBasedOnDurations($durationTimes);

    return [
      'label' => $timeSegment->getLabel(),
      'average' => $stats['average'],
      'min' => $stats['min'],
      'max' => $stats['max'],
      'stdDev' => $stats['stdDev'],
      'loopCount' => $loopCount
    ];
  }

  private function calculateStatisticForSingleTimeSegment(SingleTimeSegment $timeSegment) : array {
    return [
      'label' => $timeSegment->getLabel(),
      'duration' => $timeSegment->getDuration()
    ];
  }

  /**
   * Entry point for calculating statistic for time segments collected during currnet request.
   */
  public function calculateStatisticsForRequest() : void {
    foreach ($this->timeSegments as $timeSegment) {
      if ($timeSegment instanceof LoopedTimeSegment) {
        $timeSegmentStatistic = $this->calculateStatisticForLoopedTimeSegment($timeSegment);
      } else if ($timeSegment instanceof SingleTimeSegment) {
        $timeSegmentStatistic = $this->calculateStatisticForSingleTimeSegment($timeSegment);
      }

      $this->statisticDataForRequest[$timeSegment->getLabel()][] = $timeSegmentStatistic;
    }
  }
}
