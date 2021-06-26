<?php
namespace Instapage\Components\v70\Filter;

use Instapage\Models\Component as ModelComponent;

/**
 * Model for filter component
 *
 */
class FilterModel extends ModelComponent
{
    public function getSectionTitle() : string
    {
        return (string) get_field('filter_section_title');
    }
    
    public function getSectionSubtitle() : string
    {
        return (string) get_field('filter_section_subtitle');
    }

    public function getInnerComponent() : string
    {
        return (string) get_field('filter_inner_component');
    }

    public function getFilters() : array
    {
        $repeater = get_field('filter_repeater');

        if (!is_array($repeater)) {
            $repeater = [];
        }

        return $this->constrainOneActiveFilter($repeater);
    }

    protected function constrainOneActiveFilter(array $filters) : array
    {
        $wasActive = false;

        foreach ($filters as &$filter) {
            if ($filter['visiblility'] === 'active') {
                if ($wasActive) {
                    $filter['visiblility'] = '';
                }
                $wasActive = true;
            }
        }

        return $filters;
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
            'innerComponent',
            'filters'
        ];
    }
}
