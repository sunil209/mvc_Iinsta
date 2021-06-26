<?php
namespace Instapage\Components\v51\RelatedLinks;

use Instapage\Models\Component as ModelComponent;

class RelatedLinksModel extends ModelComponent {

  /**
   * Gets an array with `related links` from ACF
   * @return array
   */
  public function getItems() {
    $items = [];

    while (have_rows('related_links')) {
      the_row();
      $items[] = [
        'linkName' => get_sub_field('link_name'),
        'linkUrl' => get_sub_field('link_url'),
      ];
    }

    return $items;
  }

  /**
   * @return string
   */
  public function getTitle() : string {

    return (string) get_field('related_links_section_title');
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
      'title'
    ];
  }

}
