<?php
namespace Instapage\Components\v70\Columns;

use Instapage\Models\Component;

/**
 * Model for columns component
 *
 */
class ColumnsModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('columns_section_title');
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_field('columns_section_subtitle');
    }

    public function getColumns() : array
    {
        return (array) get_field('columns');
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
            'columns'
        ];
    }
}
