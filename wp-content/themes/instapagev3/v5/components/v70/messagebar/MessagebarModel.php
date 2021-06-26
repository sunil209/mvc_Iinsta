<?php
namespace Instapage\Components\v70\Messagebar;

use Instapage\Models\Component;

/**
 * Model for messagebar component
 *
 */
class MessagebarModel extends Component
{
    public function getIsOn() : bool
    {
        return (bool) get_field('messagebar_is_on', 'option');
    }

    public function getTitle() : string
    {
        return (string) get_field('messagebar_title', 'option');
    }
    
    public function getButton() : array
    {
        return (array) get_field('messagebar_button', 'option');
    }
    
    /**
     * Method from abstract class telling which info model can generate
     *
     * @return array
     */
    public function getParamsListToInject() : array
    {
        return [
            'title',
            'isOn',
            'button'
        ];
    }
}
