<?php
namespace Instapage\Components\v70\FeatureRepeater;

use Instapage\Models\Component;

/**
 * Model for v7 Feature component
 *
 */
class FeatureRepeaterModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('feature_repeater_section_title');
    }
    
    public function getSectionSubtitle() : string
    {
        return (string) get_field('feature_repeater_section_subtitle');
    }

    public function getRepeaterLayout() : string
    {
        $repeaterLayoutField = get_field('feature_repeater_layout');

        if ($repeaterLayoutField === 'row') {
            $repeaterLayout = 'v7-feature-repeater-container-row';
        } elseif ($repeaterLayoutField === 'tile') {
            $repeaterLayout = 'v7-feature-repeater-container-tile';
        } else {
            $repeaterLayout = 'v7-feature-repeater-container-column';
        }

        return $repeaterLayout;
    }

    public function getRepeater() : array
    {
        return (array) get_field('feature_repeater');
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
            'repeaterLayout',
            'repeater'
        ];
    }
}
