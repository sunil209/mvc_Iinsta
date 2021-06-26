<?php

namespace Instapage\Classes;

/**
 * Class encapsuling all functionality asociated
 * with environement - is it uat/live/localhost?
 */
class Environment {

  /**
   * @var array $serverInformation $_SERVER PHP predefined variable
   */
  protected $serverInformation;

  const UAT_IPs = [
    'suntsu-uat-1' => '10.128.0.5',
    'suntsu-uat-2' => '10.128.0.4',
    'suntsu-uat-3' => '10.128.0.3'
  ];

  const LIVE_IPs = [
    'website-worker-1' => '10.128.0.7',
    'website-worker-2' => '10.128.0.6',
    'website-worker-3' => '10.128.0.8'
  ];

  /**
   * Create object to find out some information about environment where wordpress is run.
   *
   * @param array $serverInformation $_SERVER PHP predefined variable
   */
  public function __construct(array $serverInformation) {
    $this->serverInformation = $serverInformation;
  }

  /**
   * Check if current server IP is in IP pool array.
   *
   * @param array $ipPool      Array with key => value as 'host-name' => 'ip-address'
   * @param string $serverName Sever name for exception message
   *
   * @return bool
   * @throws \Exception Exception is thrown when it is not possible to get server ip address
   */
  protected function checkIfServerIPIsInPool(array $ipPool, string $serverName) : bool {
    try {
      return in_array(
        $this->getServerIP(),
        array_values($ipPool)
      );
    } catch (\Exception $ex) {
      throw new \Exception('It is impossible to know if it is ' . $serverName . ', not enough data', 0, $ex);
    }
  }

  /**
   * Get server IP wheren PHP script is run
   *
   * @return string Server IP
   * @throws \Exception Throws exception when server IP cannot be obtained
   */
  public function getServerIP() : string {
    if (!isset($this->serverInformation['SERVER_ADDR'])) {
      throw new \Exception('Server addres is not avaiable');
    }

    return $this->serverInformation['SERVER_ADDR'];
  }

  /**
   * Check if wordpress is run on our uats server?
   *
   * @return bool
   */
  public function isItUAT() : bool {
    return $this->checkIfServerIPIsInPool(self::UAT_IPs, 'UAT server');
  }

  /**
   * Check if wordpress is run on our live servers
   *
   * @return bool
   */
  public function isItLive() : bool {
    return $this->checkIfServerIPIsInPool(self::LIVE_IPs, 'Live server');
  }
}
