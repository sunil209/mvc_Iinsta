<?php
namespace Instapage\Components\v70\BenefitsSection;

use Instapage\Models\IteratorComponent;

/**
 * Model for benefits section
 */
class BenefitsSectionModel extends IteratorComponent
{
    public function getSectionTitle() : string
    {
        return (string) get_sub_field('benefits_section_title');
    }
    
    public function getSectionSubtitle() : string
    {
        return (string) get_sub_field('benefits_section_subtitle');
    }

    public function getLayout() : string
    {
        return (string) get_sub_field('layout');
    }

    public function getBenefits() : array
    {
        return (array) get_sub_field('benefits');
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
            'benefits'
        ];
    }
}
