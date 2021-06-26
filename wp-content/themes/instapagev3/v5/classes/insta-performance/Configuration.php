<?php

namespace Instapage\Classes\InstaPerformance;

/**
 * Class holding configuration for InstaPerformance tool.
 *
 * @author konrad-stalega
 */
class Configuration {
  /**
   * @var ?string $testOverRequests If there is a string set it means that test over request is set
   */
  private $testOverRequests = null;
  /**
   * @var string $directoryToSaveRaport Path do directory where raports are stored
   */
  private $directoryToSaveRaports = '';

  /**
   * Enable test over request and set his name. What test over request means?
   * That each time segments measured in one request are aggregated among many request
   * and stats are calculated.
   *
   * @param string $testName
   * @return bool
   */
  public function setTestOverRequests(string $testName) : bool {
    $this->testOverRequests = $testName;
    return true;
  }

  public function getTestOverRequestsName() : ?string {
    return $this->testOverRequests;
  }

  public function isTestOverRequestEnabled() : bool {
    return $this->testOverRequests !== null;
  }

  public function setDirectoryForRaports(string $directory) : void {
    $this->directoryToSaveRaports = $directory;
  }

  public function geDirectoryForRaports() : string {
    // if directory was not set and there is wordpress environment read it from there
    if ($this->directoryToSaveRaports === '' && defined('ABSPATH')) {
      return ABSPATH . 'reports/';
    }

    return $this->directoryToSaveRaports;
  }
}
