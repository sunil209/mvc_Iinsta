<?php
namespace Instapage\Models;

/**
 * Model for landing pages
 */
class LandingPage extends Root {
  /**
   * Gets an array with benefits from ACF
   * @return array
   */
  public function getBenefits() {
    $items = [];

    if (have_rows('benefits')) {
      while (have_rows('benefits')) {
        the_row();
        $items[] = [
          'name' => get_sub_field('name'),
          'description' => get_sub_field('description'),
          'icon' => get_sub_field('icon'),
          'smallHeadline' => true
        ];
      }
    }

    return $items;
  }
}
