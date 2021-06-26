<?php

namespace Instapage\Classes\InstaPerformance;

/**
 * Class holding methods for calculating basic properties for set of numbers.
 */
class Math {
  /**
   * Calculate average of numbers in array
   *
   * @param array $arrayWithNumbers
   * @return float
   * @throws \Exception
   */
  public static function average(array $arrayWithNumbers) : float {
    if (count($arrayWithNumbers) === 0) {
      throw new \Exception('There are no elements in array, so we cannot find avg value');
    }

    $count = count($arrayWithNumbers);
    return array_sum($arrayWithNumbers) / $count;
  }

  /**
   * Find min number in array of numbers
   *
   * @param array $arrayWithNumbers
   * @return int|float
   * @throws \Exception
   */
  public static function min(array $arrayWithNumbers) {
    if (count($arrayWithNumbers) === 0) {
      throw new \Exception('There are no elements in array, so we cannot find min value');
    }

    $min = $arrayWithNumbers[0];

    foreach ($arrayWithNumbers as $number) {
      $min = $min > $number ? $number : $min;
    }

    return $min;
  }

  /**
   * Find max number in array of numbers
   *
   * @param array $arrayWithNumbers
   * @return int|float
   * @throws \Exception
   */
  public static function max(array $arrayWithNumbers) {
    if (count($arrayWithNumbers) === 0) {
      throw new \Exception('There are no elements in array, so we cannot find min value');
    }

    $max = $arrayWithNumbers[0];

    foreach ($arrayWithNumbers as $number) {
      $max = $max < $number ? $number : $max;
    }

    return $max;
  }


  /**
   * Calculate standard deviation for numbers in given array.
   *
   * @param array $arrayWithNumbers
   * @return float
   * @throws \Exception
   */
  public static function stdDev(array $arrayWithNumbers) {
    $count = count($arrayWithNumbers);
    if ($count === 0) {
        throw new Exception('The array has zero elements');
    }

    $mean = array_sum($arrayWithNumbers) / $count;
    $carry = 0.0;
    foreach ($arrayWithNumbers as $number) {
        $substract = ((double) $number) - $mean;
        $carry += $substract ** 2;
    };

    return sqrt($carry / $count);
  }
}
