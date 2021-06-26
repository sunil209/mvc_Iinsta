<?php
namespace Instapage\Components\v70\BackgroundGradient;

use Instapage\Models\Component;
use Instapage\Helpers\AcfHelper;

/**
 * Model for v7 address component
 *
 */
class BackgroundGradientModel extends Component
{
    public function getIsBackgroundGradient() : bool
    {
        return (bool) get_field('is_background_gradient');
    }

    public function getBackgroundGradientPosition() : string
    {
        return (string) get_field('background_gradient_position');
    }

    public function getButton() : array
    {
        $btnArray = get_field('background_gradient_button_bottom');

        if (($btnArray['show_button'] ?? false) === true) {
            return AcfHelper::parseButtonAttributes($btnArray['button']);
        }

        return [];
    }

    /**
    * Method from abstract class telling which info model can generate
    *
    * @return array
    */
    public function getParamsListToInject(): array
    {
        return [
            'isBackgroundGradient',
            'backgroundGradientPosition',
            'button'
        ];
    }
}
