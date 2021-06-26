<?php

namespace Instapage\Models;

/**
 * Abstract class for component's model.
 *
 */
abstract class Component {
  /**
   * @var array $rawParams Parameters passed to render component function
   */
  protected $rawParams = [];

  /**
   * @var ?int $contextID ID of post from we want to take all information
   */
  protected $contextID = null;

  /**
   * @param ?int $contextID
   */
  public function setContextID(?int $contextID) : void
  {
    $this->contextID = $contextID;
  }

  /**
   * Returns list of all params to get for component.
   * Getting of params is automatic if given param is not defined and function
   * with getParamName() exists.
   *
   * @return array $paramsListToTake Example: ['items', 'title']
   */
  abstract public function getParamsListToInject() : array;

  /**
   * Get function name which returns value for given parameter.
   *
   * @param string $paramName Name of parameter to find connected function
   * @return string Function name to call for generating value of given parameter of name $paramName
   */
  private function getFetchingFunctionName(string $paramName) : string {
    return 'get' . ucfirst($paramName);
  }

  /**
   * Get parameter value [parameter with name $paramName] from component model
   *
   * @param string $paramName Name of parameter to find value for
   * @return mixed $result Value of parameter
   */
  private function getParamFromModel($paramName) {
    $result = null;
    $fetchingFunctionName = $this->getFetchingFunctionName($paramName);
    if (method_exists($this, $fetchingFunctionName)) {
      $result = $this->$fetchingFunctionName();
    }

    return $result;
  }

  /**
   * See what parameters can component's model provide and fetch them if not set during component render call.
   *
   * @param  array  $params An array of parameters passed to component template.
   * @param  array  $params An array of parameters passed to component template plus data auto fetched from model.
   */
  public function fetchComponentParams(array $params = []) : array {
    $this->rawParams = $params;
    $this->contextID = $params['contextID'] ?? null;
    $paramsToInject = $this->getParamsListToInject();
    foreach ($paramsToInject as $paramName) {
      $params[$paramName] = $params[$paramName] ?? $this->getParamFromModel($paramName);
    }

    return $params;
  }
}
