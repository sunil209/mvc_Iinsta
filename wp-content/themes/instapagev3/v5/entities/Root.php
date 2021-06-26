<?php
namespace Instapage\Entities;

/**
 * Common functionalities for all entities
 */
class Root {
  public function __construct(array $properties = []) {
    if (!empty($properties)) {
      foreach ($properties as $propertyName => $propertyValue) {
        if (property_exists($this, $propertyName)) {
          $this->{$propertyName} = $propertyValue;
        }
      }
    }
  }
}
