<?php
namespace Instapage\Components\v70\ImageRepeater;

use Instapage\Models\IteratorComponent;

/**
 * Model for image-repeater component
 *
 */
class ImageRepeaterModel extends IteratorComponent
{
    public function getSectionTitle() : string
    {
        return (string) get_field('image_repeater_section_title');
    }
    
    public function getSectionSubtitle() : string
    {
        return (string) get_field('image_repeater_section_subtitle');
    }

    public function getImages() : array
    {
        return (array) get_sub_field('images');
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
            'images'
        ];
    }
}
