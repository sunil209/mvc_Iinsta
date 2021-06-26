<?php
namespace Instapage\Components\v70\Lists;

use Instapage\Models\IteratorComponent;

/**
 * Model for v7 list component
 *
 */
class ListsModel extends IteratorComponent
{
    public function getSectionTitle() : string
    {
        return (string) get_sub_field('lists_section_title');
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_sub_field('lists_section_subtitle');
    }

    public function getLayout() : string
    {
        return (string) get_sub_field('type_of_list');
    }

    public function getLists(): array
    {
        return get_sub_field('items');
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
            'lists'
        ];
    }
}
