<?php
namespace Instapage\Components\v70\ExpandableTiles;

use Instapage\Models\Component;

/**
 * Model for v7 Expandable tiles component
 *
 */
class ExpandableTilesModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('expandable_tiles_section_title');
    }
    
    public function getSectionSubtitle() : string
    {
        return (string) get_field('expandable_tiles_section_subtitle');
    }

    public function getExpandableTiles() : array
    {
        return (array) get_field('expandable_tiles_repeater');
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
            'expandableTiles'
        ];
    }
}
