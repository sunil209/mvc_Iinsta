<?php
namespace Instapage\Components\v70\Tiles;

use Instapage\Models\Component;

/**
 * Model for v7 tile component
 *
 */
class TilesModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('tiles_section_title', $this->contextID ?? false);
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_field('tiles_section_subtitle', $this->contextID ?? false);
    }

    public function getTiles(): array
    {
        $items = [];
        while (have_rows('tile_repeater_repeater', $this->contextID ?? false)) {
            the_row();
            $items[] = [
              'image' => get_sub_field('image'),
              'title' => get_sub_field('title'),
              'url' => get_sub_field('url'),
              'moreText' => get_sub_field('moreText')
            ];
        }

        return $items;
    }

    /**
    * Method from abstract class telling which info model can generate
    *
    * @return array
    */
    public function getParamsListToInject(): array
    {
        return [
            'sectionTitle',
            'sectionSubtitle',
            'tiles'
        ];
    }
}
