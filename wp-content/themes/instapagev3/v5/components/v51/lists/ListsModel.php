<?php
namespace Instapage\Components\v51\Lists;
use Instapage\Models\IteratorComponent;
/**
 * Model for list component
 *
 */
class ListsModel extends IteratorComponent {
  public function getItems() {
    return get_sub_field('items');
  }
  /**
   * Method from abstract class telling which info model can generate
   *
   * @return array
   */
  public function getParamsListToInject() : array {
    return [
      'items'
    ];
  }
}
