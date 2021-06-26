<?php
namespace Instapage\Components\v70\LeftRight;

use Instapage\Models\IteratorComponent;

/**
 * Model for Left-Right component
 *
 */
class LeftRightModel extends IteratorComponent
{
    public function getSectionTitle() : string
    {
        return (string) get_sub_field('left_right_section_title');
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_sub_field('left_right_section_subtitle');
    }

    public function getLeftRightLayout() : bool
    {
        return (bool) get_sub_field('layout');
    }

    public function getRenderTileUnderImage() : bool
    {
        return (bool) get_sub_field('tile_under_image');
    }

    public function getShowNavigation() : bool
    {
        return (bool) get_sub_field('left_right_show_navigation');
    }

    public function getLeftRightRows() : array
    {
        return (array) get_sub_field('left_right_rows');
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
            'leftRightLayout',
            'showNavigation',
            'leftRightRows',
            'renderTileUnderImage'
        ];
    }
}
