<?php
namespace Instapage\Components\v70\Feature;

use Instapage\Models\Component;

/**
 * Model for v7 Feature component
 *
 */
class FeatureModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('feature_section_title');
    }
    
    public function getSectionSubtitle() : string
    {
        return (string) get_field('feature_section_subtitle');
    }

    public function getTitle() : string
    {
        return (string) get_field('feature_title');
    }
    
    public function getSubtitle() : string
    {
        return (string) get_field('feature_subtitle');
    }
    
    public function getImage() : string
    {
        return (string) get_field('feature_image');
    }
    
    public function getButtonText() : string
    {
        return (string) get_field('feature_button_text');
    }

    public function getUrl() : string
    {
        return (string) get_field('feature_url');
    }
    
    public function getVariant() : bool
    {
        return (bool) get_field('feature_variant');
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
            'title',
            'subtitle',
            'image',
            'buttonText',
            'url',
            'variant'
        ];
    }
}
