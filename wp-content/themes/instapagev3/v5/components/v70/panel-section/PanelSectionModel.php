<?php
namespace Instapage\Components\v70\PanelSection;

use Instapage\Models\IteratorComponent;
use Instapage\Helpers\AcfHelper;

/**
 * Model for panel-repeater component
 *
 */
class PanelSectionModel extends IteratorComponent
{
    public function getSectionTitle() : string
    {
        return (string) get_sub_field('panel_section_title');
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_sub_field('panel_section_subtitle');
    }

    public function getLayout() : string
    {
        return (string) get_sub_field('layout');
    }

    public function getIsFlat() : bool
    {
        return (bool) get_sub_field('is_flat');
    }

    public function getPanels() : array
    {
        return (array) get_sub_field('panels');
    }

    public function getButton() : array
    {
        if (get_sub_field('show_button') === true) {
            return AcfHelper::parseButtonAttributes(get_sub_field('button'));
        }
        
        return [];
    }

    /**
     * Method from abstract class telling which info model can generate
     *
     * @return array
     */
    public function getParamsListToInject() : array
    {
        return [
            'sectionTitle',
            'sectionSubtitle',
            'layout',
            'isFlat',
            'panels',
            'button'
        ];
    }
}
