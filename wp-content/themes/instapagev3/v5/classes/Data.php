<?php

namespace Instapage\Classes;

/**
 * Class for safely getting input data. It is wrapper for filter_input() php native function.
 * List of filters: http://php.net/manual/en/filter.filters.php
 *
 * Example of usage:
 *
 * > This three are equal [This is reason for shortcutes], see how long is to use only native methods:
 *   $pageV0 = is_int($i = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT)) ? $i : 1;
 *   $pageV1 = Data::_('get', 'page', 1, FILTER_VALIDATE_INT);
 *   $pageV2 = Data::_get('page', 1, FILTER_VALIDATE_INT);
 *   $pageV3 = Data::_int('get', 'page', 1);
 *
 * > This three are equal [This is reason for shortcutes]:
 *   $priceV1 = Data::_('get', 'price', 0.00, FILTER_VALIDATE_FLOAT);
 *   $priceV2 = Data::_get('price', 0.00, FILTER_VALIDATE_FLOAT);
 *   $priceV3 = Data::_float('get', 'price', 0.00);
 *
 * > This three are equal [This is reason for shortcutes]:
 *   $pricePostV0 = is_float($i = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT)) ? $i : 10.00;
 *   $pricePostV1 = Data::_('post', 'price', 10.00, FILTER_VALIDATE_FLOAT);
 *   $pricePostV2 = Data::_post('price', 10.00, FILTER_VALIDATE_FLOAT);
 *   $pricePostV3 = Data::_float('post', 'price', 10.00);
 *
 */
class Data {
  /**
   * @var Array All aliases for avaiable data input types, it is just shortcut for typing
   */
  const INPUT_DATA_TYPES_ALIASES = [
    'get' => INPUT_GET,
    'post' => INPUT_POST,
    'cookie' => INPUT_COOKIE,
    'server' => INPUT_SERVER,
    'env' => INPUT_ENV
  ];

  /**
   * Check if input type defined by integer is proper range.
   * If filter_input() php native function recognize it?
   *
   * @param int $inputDataType Number representing input data type
   * @return bool True if type represented by integer is in proper range
   */
  private static function checkIfTypeDefinedByNumberIsProper(int $inputDataType) : bool {
    // if passed int is in array of available types return true
    return in_array(
      $inputDataType,
      array_values(Data::INPUT_DATA_TYPES_ALIASES)
    );
  }

  /**
   * Determine input data type based on input parameter.
   * We allow string[shortcutes] and native php constant
   * accepted but filter_inputs()
   *
   * @param string|int $inputDataType Input data type, can be string: 'get', 'post', 'cookie', 'server', 'env' or native php constant one of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
   *
   * @uses self::checkIfTypeDefinedByNumberIsProper()
   *
   * @return int
   * @throws \Exception
   */
  private static function determineDataType($inputDataType) : int {
    if (
      is_int($inputDataType)
      && self::checkIfTypeDefinedByNumberIsProper($inputDataType)
    ) {
      return $inputDataType;
    } else if (
      is_string($inputDataType)
      && isset(self::INPUT_DATA_TYPES_ALIASES[$inputDataType])
    ) {
      return self::INPUT_DATA_TYPES_ALIASES[$inputDataType];
    }
    throw new \Exception('Wrong input data type.');
  }

  /**
   * Get input data in safe way.
   *
   * This method is extend of php native filter_input() function.
   *
   * @param string|int $inputDataType Input data type, can be string: 'get', 'post', 'cookie', 'server', 'env' or native php constant one of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
   * @param string     $variableName  Name of a variable to get.
   * @param mixed      $defaultValue  Default value of variable if filter failed or variable is not set
   * @param int        $filter        The ID of the filter to apply. The Types of filters manual page lists the available filters: http://php.net/manual/en/filter.filters.php
   *
   * @uses self::determineDataType()
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
   */
  public static function _($inputDataType, string $variableName, $defaultValue = null, int $filter = FILTER_DEFAULT) {
    $filterEffect = filter_input(
      self::determineDataType($inputDataType),
      $variableName,
      $filter
    );

    // filter failed [false] or variable is not set [null]
    if ($filterEffect === false || $filterEffect === null) {
      return $defaultValue;
    }
    return $filterEffect;
  }

  /**
   * Shortcut method for getting get variables. It just calls self::_() with first parameter set.
   *
   * @param string     $variableName  Name of a variable to get.
   * @param mixed      $defaultValue  Default value of variable if filter failed or variable is not set
   * @param int        $filter        The ID of the filter to apply. The Types of filters manual page lists the available filters: http://php.net/manual/en/filter.filters.php
   *
   * @uses self::_()
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
  */
  public static function _get(string $variableName, $defaultValue = null, int $filter = FILTER_DEFAULT) {
    return self::_(INPUT_GET, $variableName, $defaultValue, $filter);
  }

  /**
   * Shortcut method for getting post variables. It just calls self::_() with first parameter set.
   *
   * @param string     $variableName  Name of a variable to get.
   * @param mixed      $defaultValue  Default value of variable if filter failed or variable is not set
   * @param int        $filter        The ID of the filter to apply. The Types of filters manual page lists the available filters: http://php.net/manual/en/filter.filters.php
   *
   * @uses self::_()
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
  */
  public static function _post(string $variableName, $defaultValue = null, int $filter = FILTER_DEFAULT) {
    return self::_(INPUT_POST, $variableName, $defaultValue, $filter);
  }

  /**
   * Shortcut method for getting cookie variables. It just calls self::_() with first parameter set.
   *
   * @param string     $variableName  Name of a variable to get.
   * @param mixed      $defaultValue  Default value of variable if filter failed or variable is not set
   * @param int        $filter        The ID of the filter to apply. The Types of filters manual page lists the available filters: http://php.net/manual/en/filter.filters.php
   *
   * @uses self::_()
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
  */
  public static function _cookie(string $variableName, $defaultValue = null, int $filter = FILTER_DEFAULT) {
    return self::_(INPUT_COOKIE, $variableName, $defaultValue, $filter);
  }

  /**
   * Shortcut method for getting server variables. It just calls self::_() with first parameter set.
   *
   * @param string     $variableName  Name of a variable to get.
   * @param mixed      $defaultValue  Default value of variable if filter failed or variable is not set
   * @param int        $filter        The ID of the filter to apply. The Types of filters manual page lists the available filters: http://php.net/manual/en/filter.filters.php
   *
   * @uses self::_()
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
  */
  public static function _server(string $variableName, $defaultValue = null, int $filter = FILTER_DEFAULT) {
    return self::_(INPUT_SERVER, $variableName, $defaultValue, $filter);
  }

  /**
   * Shortcut method for getting env variables. It just calls self::_() with first parameter set.
   *
   * @param string     $variableName  Name of a variable to get.
   * @param mixed      $defaultValue  Default value of variable if filter failed or variable is not set
   * @param int        $filter        The ID of the filter to apply. The Types of filters manual page lists the available filters: http://php.net/manual/en/filter.filters.php
   *
   * @uses self::_()
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
  */
  public static function _env(string $variableName, $defaultValue = null, int $filter = FILTER_DEFAULT) {
    return self::_(INPUT_ENV, $variableName, $defaultValue, $filter);
  }

  /**
   * Shortcut method for getting ints using FILTER_VALIDATE_INT.
   *
   * @param string|int $inputDataType Input data type, can be string: 'get', 'post', 'cookie', 'server', 'env' or native php constant one of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
   * @param string     $variableName  Name of a variable to get.
   * @param mixed      $defaultValue  Default value of variable if filter failed or variable is not set
   *
   * @uses self::_()
   *
   * @param type       $defaultValue  Default value of variable if filter failed or variable is not set
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
   */
  public static function _int($inputDataType, string $variableName, $defaultValue = null) {
    return self::_($inputDataType, $variableName, $defaultValue, FILTER_VALIDATE_INT);
  }

  /**
   * Shortcut method for getting floats using FILTER_VALIDATE_FLOAT.
   *
   * @param string|int $inputDataType Input data type, can be string: 'get', 'post', 'cookie', 'server', 'env' or native php constant one of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
   * @param string     $variableName  Name of a variable to get.
   * @param mixed      $defaultValue  Default value of variable if filter failed or variable is not set
   *
   * @uses self::_()
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
   */
  public static function _float($inputDataType, string $variableName, $defaultValue = null) {
    return self::_($inputDataType, $variableName, $defaultValue, FILTER_VALIDATE_FLOAT);
  }

  /**
   * Shortcut method for getting variables which is string. It just calls self::_() with last two parameters set.
   *
   * @param string|int $inputDataType Input data type, can be string: 'get', 'post', 'cookie', 'server', 'env' or
   *                                  native php constant one of INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER,
   *                                  or INPUT_ENV.
   * @param string     $variableName  Name of a variable to get.
   *
   * @uses self::_()
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
  */
  public static function _string($inputDataType, string $variableName) {
    return self::_($inputDataType, $variableName, '', FILTER_SANITIZE_STRING);
  }

  /**
   * Shortcut method for getting post variables which is string. It just calls self::_() with three parameters set.
   *
   * @param string     $variableName  Name of a variable to get.
   *
   * @uses self::_()
   *
   * @return mixed Return value of variable when filter did not fail or variable is set
  */
  public static function _stringFromPost(string $variableName) {
    return self::_(INPUT_POST, $variableName, '', FILTER_SANITIZE_STRING);
  }
}
