<?php
namespace Instapage\Components\v51\Accordion;

use Instapage\Models\Component as ModelComponent;

/**
 * Description of model-accordion
 */
class AccordionModel extends ModelComponent {

  /**
   * Gets an array with `accordions` from ACF
   * @return array
   */
  public function getItems() {
    $items = [];

    while (have_rows('accordion', $this->contextID)) {
      the_row();
      $items[] = [
        'title' => get_sub_field('title'),
        'excerpt' => get_sub_field('excerpt'),
        'url' => get_sub_field('url'),
        'icon' => get_sub_field('icon')['url'] ?? null,
        'isOpen' => get_sub_field('is_open')
      ];
    }

    return $items;
  }

  /**
   * Return list of parameters that model can provide.
   *
   * Remember that if paramter name is items, function which will fetch data for this parameter is getItems() etc.
   *
   * @return array Array containg parametes name that model can provide
   */
  public function getParamsListToInject() : array {
    return [
      'items',
    ];
  }

}
