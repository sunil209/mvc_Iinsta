<?php
namespace Instapage\Components\v51\CtaSection;

use Instapage\Models\Component as ModelComponent;
use Instapage\Classes\Component;

/**
 * Description of model-cta-section
 */
class CtaSectionModel extends ModelComponent {

  /**
   * Gets string with `cta section` from ACF
   * @return string
   */
  public function getTitle() {
    return get_field('cta_title');
  }

  public function getSubtitle() {
    return get_field('cta_subtitle');
  }

  public function getSubtitleBottom() {
    return get_field('cta_subtitle_bottom');
  }

  protected function getButtons() : array {
    /**
     * @var $buttonsModel \Instapage\Components\v51\ButtonsGroup\ButtonsGroupModel
     */
    $buttonsModel = Component::getComponentModel('buttons-group', 'v51');
    $buttonsModel->setRepeaterName('cta_buttons');
    $buttonsModel->setContextID($this->contextID);
    $buttons = $buttonsModel->getButtons();

    return $buttons;
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
      'title',
      'subtitle',
      'subtitleBottom',
      'buttons'
    ];
  }

}
