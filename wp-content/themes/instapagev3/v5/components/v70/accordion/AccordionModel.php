<?php
namespace Instapage\Components\v70\Accordion;

use Instapage\Models\Component as ModelComponent;

class AccordionModel extends ModelComponent
{
    public function getSectionTitle() : string
    {
        return (string) get_field('accordion_section_title', $this->contextID);
    }
    
    public function getSectionSubtitle() : string
    {
        return (string) get_field('accordion_section_subtitle', $this->contextID);
    }

    /**
     * Gets an array with `accordions` from ACF
     * @return array
     */
    public function getAccordions()
    {
        return (array) get_field('accordions', $this->contextID) ?? [];
    }

    /**
     * @return array Array containg parametes name that model can provide
     */
    public function getParamsListToInject() : array
    {
        return [
            'sectionTitle',
            'sectionSubtitle',
            'accordions'
        ];
    }
}
