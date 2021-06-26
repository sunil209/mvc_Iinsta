<?php
namespace Instapage\Components\v51\BenefitsSection;
use Instapage\Models\IteratorComponent;

/**
 * Model for benefist section
 */
class BenefitsSectionModel extends IteratorComponent {
  
  public function getTitle() : string {
    return get_sub_field('title');
  }

  public function getBenefits() : array {
    return get_sub_field('benefits');
  }

  /**
   * Method from abstract class telling which info model can generate
   *
   * @return array
   */
  public function getParamsListToInject() : array {
    return [
      'title',
      'benefits'
    ];
  }
}
