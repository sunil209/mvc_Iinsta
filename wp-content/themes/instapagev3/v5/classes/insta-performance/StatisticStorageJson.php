<?php

namespace Instapage\Classes\InstaPerformance;

use Instapage\Classes\InstaPerformance\{
  StatisticStorageInterface,
  Configuration
};

/**
 * Class for storing statistic in json file - read and write operations.
 */
class StatisticStorageJson implements StatisticStorageInterface {

  /**
   * @var Configuration
   */
  protected $ipConfiguration;

  public function __construct(Configuration $instaPerformanceConfiguration) {
    $this->ipConfiguration = $instaPerformanceConfiguration;
  }

  private function getReportFilePath() : string {
    return $this->ipConfiguration->geDirectoryForRaports() . $this->getReportFileName();
  }

  private function getReportFileName() : string {
    if ($this->ipConfiguration->isTestOverRequestEnabled()) {
      return 'ipOR-raport-' . $this->ipConfiguration->getTestOverRequestsName() . '.json';
    }

    return 'ip-raport-' . date('d-m-Y_His') . '.json';
  }

  /**
   * Write statistic data to the storage
   *
   * @param array $statisticData
   */
  public function write(array $statisticData) : void {
    $directory = $this->ipConfiguration->geDirectoryForRaports();
    if (!is_dir($directory)) {
      mkdir($directory);
    }

    $result = file_put_contents($this->getReportFilePath(), json_encode($statisticData));
  }

  /**
   * Read statistic data from the storage
   *
   * @return array
   */
  public function read() : array {
    $jsonRaport = false;
    if (!$this->ipConfiguration->isTestOverRequestEnabled()) {
      return [];
    }

    if (file_exists($this->getReportFilePath())) {
      $jsonRaport = file_get_contents($this->getReportFilePath());
    }

    if ($jsonRaport !== false) {
      return json_decode($jsonRaport, true);
    }

    return [];
  }
}
