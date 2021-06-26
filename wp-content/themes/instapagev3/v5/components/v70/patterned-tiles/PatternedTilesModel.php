<?php
namespace Instapage\Components\v70\PatternedTiles;

use Instapage\Models\Component;

/**
 * Model for v7 Patterned tiles component
 *
 */
class PatternedTilesModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('patterned_tiles_section_title');
    }
    
    public function getSectionSubtitle() : string
    {
        return (string) get_field('patterned_tiles_section_subtitle');
    }

    public function getPatternedTiles() : array
    {
        return (array) get_field('patterned_tiles_repeater');
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
            'patternedTiles'
        ];
    }
}
