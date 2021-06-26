<?php
namespace Instapage\Models;

/**
 * Model for /about page
 */
class About extends Root {
  /**
   * Gets an array of slider images from ACF
   * @param  int $contextID (optional) ID of page from which ACF data should be pulled from
   * @return array
   */
  public function getSlides($contextID = null) {
    $items = [];

    if (have_rows('slides', $contextID)) {
      while (have_rows('slides', $contextID)) {
        the_row();
        $items[] = [
          'image' => get_sub_field('image'),
          'retinaImage' => get_sub_field('retina_image'),
          'office' => get_sub_field('office')
        ];
      }
    }

    return $items;
  }

  /**
   * Gets an array of employes faces with basic details
   */
  public function getFaces() {
    $items = [];

    if (have_rows('faces')) {
      while (have_rows('faces')) {
        the_row();
        $items[] = [
          'image' => get_sub_field('image'),
          'retinaImage' => get_sub_field('image_retina'),
          'name' => get_sub_field('name'),
          'title' => get_sub_field('title'),
          'location' => get_sub_field('location')
        ];
      }
    }

    return $items;
  }
}
