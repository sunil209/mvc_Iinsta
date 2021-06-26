<?php
namespace Instapage\Components\v51\Carousel;

use Instapage\Models\Component as ModelComponent;

/**
 * Model for Carousel component.
 */
class CarouselModel extends ModelComponent {

  /**
   * Name of the repeater used by a Carousel component.
   */
  private $slidesRepeaterName = 'slides';

  public function getHeaderText() : string {
    return getAcfVar('header_text', '', $this->contextID);
  }

  public function getSubheaderText() : string {
    return getAcfVar('carousel_subheader', '', $this->contextID);
  }

  /**
   * Returns an array of slides.
   * @return array Array of slides.
   */
  public function getSlides() : array {
    $items = [];
    if (!have_rows($this->slidesRepeaterName)) {
      return $items;
    }

    while (have_rows($this->slidesRepeaterName)) {
      the_row();
      $item                       = [];
      $item['image']              = get_sub_field('slide_image');
      $item['imageRetina']        = get_sub_field('slide_image_retina');
      $item['video']              = get_sub_field('slide_video');
      $item['pointerImage']       = get_sub_field('pointer_image');
      $item['pointerImageRetina'] = get_sub_field('pointer_image_retina');
      $item['header']             = get_sub_field('slide_header');
      $item['subHeader']          = get_sub_field('slide_subheader');
      $item['text']               = get_sub_field('slide_text');
      $items[]                    = $item;
    }

    return $items;
  }

  /**
   * Returns an array of navigation items.
   * @return array Array of navigation items.
   */
  public function getNavigationItems() : array {
    $navItems = [];
    if (!have_rows($this->slidesRepeaterName)) {
      return $navItems;
    }

    while (have_rows($this->slidesRepeaterName)) {
      the_row();
      $navItem                       = [];
      $navItem['pointerImage']       = get_sub_field('pointer_image');
      $navItem['pointerImageRetina'] = get_sub_field('pointer_image_retina');
      $navItem['altText']            = get_sub_field('slide_header');
      $navItems[]                    = $navItem;
    }

    return $navItems;
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
      'headerText',
      'subheaderText',
      'slides',
      'navigationItems'
    ];
  }
}
