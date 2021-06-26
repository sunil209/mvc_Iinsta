<?php
namespace Instapage\Components\v70\DivisionHeader;

use Instapage\Models\IteratorComponent;

/**
 * Model for division-header component
 *
 */
class DivisionHeaderModel extends IteratorComponent
{
    public function getTitle() : string
    {
        return get_sub_field('title');
    }

    public function getSubtitle() : string
    {
        return get_sub_field('subtitle');
    }

    /**
     * Method from abstract class telling which info model can generate
     *
     * @return array
     */
    public function getParamsListToInject() : array
    {
        return [
            'title',
            'subtitle'
        ];
    }
}
