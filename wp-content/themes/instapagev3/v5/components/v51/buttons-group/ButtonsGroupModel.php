<?php
namespace Instapage\Components\v51\ButtonsGroup;

use Instapage\Models\Component as ModelComponent;

/**
 * Class holding all data for buttons group component
 */
class ButtonsGroupModel extends ModelComponent {

  /**
   * Get button class based on type.
   *
   * @param string $buttonType Type of button, allowed values: 'ghost-blue', 'ghost-white', 'full' if not recognized defaults to 'full'
   * @return string $buttonClass Return button class based on type
   */
  protected function getButtonClassBasedOnType(string $buttonType) : string {
    switch ($buttonType) {
      case 'ghost-blue' :
        $buttonClass = 'btn-ghost-cta';
        break;
      case 'ghost-white' :
        $buttonClass = 'btn-ghost';
        break;
      case 'white' :
        $buttonClass = 'btn-white';
        break;
      default :
        $buttonClass = 'btn-cta';
    }
    return $buttonClass;
  }

  protected function getRepeaterName() : string {
    return $this->rawParams['buttonsGroupACF'] ?? 'buttons';
  }

  public function setRepeaterName(string $repeaterName) : void {
    $this->rawParams['buttonsGroupACF'] = $repeaterName;
  }

  public function getButtons() : array {
    $buttons = [];
    $repeaterName = $this->getRepeaterName();

    while (have_rows($repeaterName, $this->contextID)) {
      the_row();
      $buttonType = get_sub_field('type');
      $buttonClass = $this->getButtonClassBasedOnType($buttonType);
      $buttonClass .= $this->rawParams['sliderContext'] ?? false === true
                      ? ' is-small'
                      : '';

      $buttonParams = [
        'text' => get_sub_field('text'),
        'url' => get_sub_field('url'),
        'class' => 'btn ' .  $buttonClass
      ];

      if (get_sub_field('video')) {
        $buttonParams['class'] .= ' js-video-trigger';
        $buttonParams['icon'] = 'play_arrow';
        $buttonParams['video'] =  true;
      }

      $buttons[] = $buttonParams;
    }

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
      'buttons'
    ];
  }
}
