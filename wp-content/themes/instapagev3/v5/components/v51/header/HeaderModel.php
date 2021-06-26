<?php
namespace Instapage\Components\v51\Header;

use Instapage\Models\Component as ModelComponent;
use Instapage\Classes\Component;

/**
 * Model for header component
 */
class HeaderModel extends ModelComponent {

  /**
   * Shortcut function for getting info from ACF in the context of this component
   *
   * @param string $fieldName Field name to get from ACF
   * @return mixed
   */
  private function getACF(string $fieldName) {
    return getAcfVar($fieldName, '', $this->contextID);
  }

  /**
   * Gets header class
   * @return string
   */
  public function getHeaderClass() {
    return $this->getACF('header_class');
  }

  /**
   * Gets header image
   * @return string
   */
  public function getHeaderImage() {
    return $this->getACF('header_image');
  }

  /**
   * Gets header image
   * @return string
   */
  public function getHeaderSideImage() {
    return $this->getACF('header_side_image');
  }

  /**
   * Gets header image
   * @return string
   */
  public function getHeaderSideImageRetina() {
    return $this->getACF('header_side_image_retina');
  }

  /**
   * Gets header text
   * @return string
   */
  public function getHeaderText() {
    return $this->getACF('header');
  }

  /**
   * Gets header sub header text
   * @return string
   */
  public function getSubHeaderText() {
    return $this->getACF('subheader');
  }

  /**
   * Method from getting buttons from new, better repeater
   *
   * @return array
   */
  protected function getButtonsFromNewRepeater() : array {
    /**
     * @var $buttonsModel \Instapage\Components\v51\ButtonsGroup\ButtonsGroupModel
     */
    $buttonsModel = Component::getComponentModel('buttons-group', 'v51');
    $buttonsModel->setRepeaterName('header_buttons');
    $buttons = $buttonsModel->getButtons();

    return $buttons;
  }

  /**
   * Get first legacy button.
   *
   * When we stop using old acf group for header we can remove this function.
   *
   * @return array
   */
  protected function getFirstLegacyButton() {
    $firstButtonParams = [
      'text' => !empty($this->rawParams['buttonText'])
                ? $this->rawParams['buttonText']
                : $this->getACF('header_button_text'),
      'url' => !empty($this->rawParams['buttonUrl'])
               ? $this->rawParams['buttonUrl']
               : $this->getACF('header_button_url'),
      'class' => 'btn btn-cta' . (($this->rawParams['sliderContext'] ?? false) ? ' is-small' : '')
    ];

    return $firstButtonParams;
  }

  /**
   * Get second legacy button.
   *
   * When we stop using old acf group for header we can remove this function.
   *
   * @return array
   */
  protected function getSecondLegacyButton() {
    $secondButtonParams = [
      'text' => !empty($this->rawParams['secondButtonText'])
                ? $this->rawParams['secondButtonText']
                : $this->getACF('header_second_button_text'),
      'url' => !empty($this->rawParams['secondButtonUrl'])
               ? $this->rawParams['secondButtonUrl']
               : $this->getACF('header_second_button_url'),
      'class' => 'btn btn btn-ghost'
    ];

    return $secondButtonParams;
  }

  /**
   * Get third legacy button.
   *
   * When we stop using old acf group for header we can remove this function.
   *
   * @return array
   */
  protected function getThirdLegacyButton() {
    $thirdButtonParams = [
      'text' => !empty($this->rawParams['videoText'])
                ? $this->rawParams['videoText']
                : __('See how it works'),
      'url' => !empty($this->rawParams['videoUrl'])
               ? $this->rawParams['videoUrl']
               : $this->getACF('header_video'),
      'class' => 'btn btn-ghost js-video-trigger',
      'icon' => 'play_arrow',
      'video' => true
    ];

    return $thirdButtonParams;
  }

  /**
   * Get buttons from old acf group for header.
   *
   * When we stop using old acf group for header we can remove this function.
   *
   * @return array
   */
  protected function getButtonsFromLegacyFields() {
    $buttons = [];

    // first button
    $firstButton = $this->getFirstLegacyButton();
    if ($firstButton['text'] && $firstButton['url']) {
      $buttons[] = $firstButton;
    }

    // second button
    $secondButton = $this->getSecondLegacyButton();
    if ($secondButton['text'] && $secondButton['url']) {
      $buttons[] = $secondButton;
    }

    // third button
    $thirdButton = $this->getThirdLegacyButton();
    if ($thirdButton['text'] && $thirdButton['url'] && ($this->rawParams['sliderContext'] ?? false) !== true) {
      $buttons[] = $thirdButton;
    }

    return $buttons;
  }

  /**
   * Gets buttons inside header.
   *
   * We had to rework buttons edition in wp dashboard.
   * So we create brand new acf group for header. Now buttons
   * are eddited in repeater. We need to keep compatibility with old group
   * so we first check if buttons are filled in new acf group if yes return them
   * otherwise take the old one. If we stop to use old acf group for header
   * we can remove legacy fields from model.
   *
   * @return array
   */
  public function getButtons() : array {
    $buttonsFromNewRepeater = $this->getButtonsFromNewRepeater();
    if (count($buttonsFromNewRepeater) > 0) {
      return $buttonsFromNewRepeater;
    }

    $buttonsFromLegacyFields = $this->getButtonsFromLegacyFields();
    return $buttonsFromLegacyFields;
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
      'headerClass',
      'headerImage',
      'headerSideImage',
      'headerSideImageRetina',
      'headerText',
      'subHeaderText',
      'buttons'
    ];
  }

}
