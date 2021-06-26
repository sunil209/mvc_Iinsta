<?php

namespace Instapage\Classes;

use Instapage\Classes\InstaPerformance\{
  Configuration,
  SingleTimeSegment,
  StatisticHandler,
  LoopedTimeSegment,
  StatisticStorageJson,
  TimeSegmentInterface
};

/**
 * InstaPerformance is class that gives ability to easily
 * measure execution time between two point in code.
 *
 * The API is very simple, there are three methods:
 *   - InstaPerformance::start('timeSegmentLabel');
 *   - InstaPerformance::stop('timeSegmentLabel');
 *   - InstaPerformance::config()->setTestOverRequests('testName');
 *
 * ----------------------------------------------------------------
 *
 * Example for measuring loop:
 *
 *   InstaPerformance::start('wholeFor');
 *   for ($i = 0; $i < 10; $i++) {
 *     InstaPerformance::start('for');
 *     $a = 15 + 12;
 *     InstaPerformance::stop('for');
 *   }
 *   InstaPerformance::stop('wholeFor');
 *
 * ----------------------------------------------------------------
 *
 * To enable test over requests just put this line anywhere:
 *
 *   InstaPerformance::config()->setTestOverRequests('testName');
 *
 */
class InstaPerformance {
  use \Instapage\Traits\Singleton;

  /**
   *
   * @var TimeSegmentInterfaces[] $timeSegments Collected time segments during the current requests.
   *                                            All objects here implements TimeSegmentInterfaces.
   *                                            Key is equal to time segment label, value to object implementing TimeSegmentInterface.
   */
  protected $timeSegments = [];

  /**
   *
   * @var Configuration $config Object holding configuration for InstaPerformance tests
   */
  protected $config;

  /**
   *
   * @var StatisticStorageJson $statisticStorage Storage for statistic, reads and writes.
   */
  protected $statisticStorage;

  /**
   * When first time instaPerformance package is used
   * there is initialization of configuration
   * and statistic storage object happens.
   */
  private function __construct() {
    $this->config = new Configuration();
    $this->statisticStorage = new StatisticStorageJson($this->config);
  }

  /**
   * At the end of execution of the whole script when instaPerformance is
   * used to measure performance perform all needed operations [calculate stats, save results etc.]
   */
  public function __destruct() {
    $this->endPerformanceMeasurements();
  }

  /**
   * Method used for doing all operation at the end of test execution.
   */
  protected function endPerformanceMeasurements() {
    $timeSegmentsCollected = array_values($this->timeSegments);

    // if there is active test set get result from earlier tests and pass it to statistic handler
    $statisticFromWholeTestSet = $this->statisticStorage->read();

    // unpacking array for getting array value type hinting and validating by php 7 feature
    $statisticHandler = new StatisticHandler($this->config, $statisticFromWholeTestSet, ...$timeSegmentsCollected);
    $performanceStatistic = $statisticHandler->getStatistics();

    // write statistic date after calculation
    $this->statisticStorage->write($performanceStatistic);
  }

  /**
   * Get configuration object for instaPerformance package
   *
   * @return Configuration
   */
  public static function config() : Configuration {
    $instaPerformance = static::getInstance();

    // return handler to configuration object
    return $instaPerformance->config;
  }

  /**
   * Method called during attempt to start time segment with label already used.
   *
   * @param string $segmentLabel
   * @throws \Exception
   */
  protected function startAttemptWithAlreadyExistingTimeSegmentLabel(string $segmentLabel) {
    if (!$this->timeSegments[$segmentLabel]->isEnded()) {
      throw new \Exception('Time segment with this label is already started, to use it in looped context you have to stop current time segment with label: ' . $segmentLabel);
    }

    // this time segment was only one used and it has start and stop point, convert it to loopedTimeSegment
    if ($this->timeSegments[$segmentLabel] instanceof SingleTimeSegment) {
      // convert single time segment to looped time segment
      $this->timeSegments[$segmentLabel] = new LoopedTimeSegment($this->timeSegments[$segmentLabel]);
      // and add new time segment
      $this->timeSegments[$segmentLabel]->add(new SingleTimeSegment($segmentLabel));
    } else if ($this->timeSegments[$segmentLabel] instanceOf LoopedTimeSegment) {
      $this->timeSegments[$segmentLabel]->add(new SingleTimeSegment($segmentLabel));
    }
  }

  /**
   * Start recording performance date during two point in code [time execution, memory consuption]
   *
   * @param string $segmentLabel
   * @throws \Exception
   */
  public static function start(string $segmentLabel) : void {
    $instaPerformance = static::getInstance();

    if (isset($instaPerformance->timeSegments[$segmentLabel])) {
      $instaPerformance->startAttemptWithAlreadyExistingTimeSegmentLabel($segmentLabel);
    } else {
      // this label is used for the first time, so create single time segment
      $instaPerformance->timeSegments[$segmentLabel] = new SingleTimeSegment($segmentLabel);
    }

  }

  /**
   * End recording performance date during two point in code [time execution, memory consuption]
   *
   * @param string $segmentLabel
   * @throws \Exception
   */
  public static function stop(string $segmentLabel) : void {
    $instaPerformance = static::getInstance();

    // check if there is time segment with given name
    if (!isset($instaPerformance->timeSegments[$segmentLabel])) {
      throw new \Exception('There is no active time segement with given label.');
    }

    // using polymorphism for stoping time segment, it can be SingleTimeSegment and LoopedTimeSegment, it doesn't matter
    $instaPerformance->timeSegments[$segmentLabel]->stop();
  }
}
