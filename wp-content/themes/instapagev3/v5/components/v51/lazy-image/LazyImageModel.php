<?php

namespace Instapage\Components\v51\LazyImage;

use Instapage\Models\Component as ModelComponent;

class LazyImageModel extends ModelComponent {

  private $imageDimnesions;

  /**
   * Get image dimnesions in array like: ['width' => x, 'height' => y]
   *
   * @return array
   */
  protected function getImageDimnesions() : array {
    // return object level cached value
    if ($this->imageDimnesions !== null) {
      return $this->imageDimnesions;
    }

    $imageDimnesions = $this->getDimnesionsFromParams();

    if ($imageDimnesions['width'] === 0 && $imageDimnesions['height'] === 0) {
      $imageDimnesions = $this->getDimnesionsFromRegularFile();
    }

    if ($imageDimnesions['width'] === 0 && $imageDimnesions['height'] === 0) {
      $imageDimnesions = $this->getDimnesionsFromSVGFile();
    }

    return $this->imageDimnesions = $imageDimnesions;
  }

  protected function formatImageDimnesions(int $width, int $height) : array {
    return [
      'width' => $width,
      'height' => $height
    ];
  }

  protected function getDimnesionsFromParams() : array {
    $width = $height = 0;
    if (
      is_int($this->rawParams['width'])
      && $this->rawParams['width'] > 0
      && is_int($this->rawParams['height'])
      && $this->rawParams['height'] > 0
    ) {
      $width = $this->rawParams['width'];
      $height = $this->rawParams['height'];
    }

    return $this->formatImageDimnesions($width, $height);
  }

  protected function getDimnesionsFromRegularFile() : array {
    $width = $height = 0;
    $imageSize = null;
    $url = $this->rawParams['imageRegularURL'] ?? '';

    if (!empty($url)) {
      $imageSize = getimagesize($url);
    }

    if (is_array($imageSize)) {
      [$width, $height] = $imageSize;
    }

    return $this->formatImageDimnesions((int) $width, (int) $height);
  }

  protected function getDimnesionsFromSVGFile() : array {
    $svgXML = simplexml_load_file($this->rawParams['imageRegularURL'] ?? '');
    $width = $height = 0;

    if ($svgXML !== false) {
      $svgAttributes = $svgXML->attributes();
      $width = (int) $svgAttributes->width;
      $height = (int) $svgAttributes->height;
    }

    return $this->formatImageDimnesions($width, $height);
  }

  /**
   * Calculate image proportion as a reseult of division height by width
   *
   * @return float
   */
  public function getImageProportion() : float {
    $proportion = $this->rawParams['proportion'] ?? 0.0;

    if ($proportion === 0.0) {
      $imageDimnesions = $this->getImageDimnesions();

      if ($imageDimnesions['width'] > 0) {
        $proportion = $imageDimnesions['height'] / $imageDimnesions['width'];
      }
    }

    return (float) round($proportion, 5);
  }

  /**
   * Don't allow to scale up image
   *
   * @return int
   */
  public function getImageMaxWidth() : int {
    return ($this->getImageDimnesions())['width'];
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
      'imageProportion',
      'imageMaxWidth'
    ];
  }
}
