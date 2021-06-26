<?php
namespace Instapage\Components\v51\Image;

use Instapage\Models\IteratorComponent;

/**
 * Model for image component
 */
class ImageModel extends IteratorComponent {

  protected function getACFImageArray(string $fieldName) : array {
    $image = get_sub_field($fieldName);

    if (is_array($image)) {
      return $image;
    } else {
      return [];
    }
  }

  public function getImage() : array {
    return $this->getACFImageArray('image');
  }

  public function getImageRetina() : array {
    return $this->getACFImageArray('image_retina');
  }


  /**
   * Method from abstract class telling which info model can generate
   *
   * @return array
   */
  public function getParamsListToInject() : array {
    return [
      'image',
      'imageRetina'
    ];
  }
}
