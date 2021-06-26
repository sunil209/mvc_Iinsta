<?php
namespace Instapage\Components\v70\Logos;

use Instapage\Models\Component;

class LogosModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('logos_section_title');
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_field('logos_section_subtitle');
    }

    /**
     * Gets an array with `logos` from ACF
     * @return array
     */
    public function getItems()
    {
        $items = [];

        while (have_rows('logos')) {
            the_row();

            $items[] = [
                'image' => get_sub_field('image')['url'] ?? null,
                'imageRetina' => get_sub_field('image_retina')['url'] ?? null
            ];
        }

        return $items;
    }

    /**
     * Return list of parameters that model can provide.
     *
     * Remember that if paramter name is items, function which will fetch data for this parameter is getItems() etc.
     *
     * @return array Array containg parametes name that model can provide
     */
    public function getParamsListToInject(): array
    {
        return [
            'items',
            'sectionTitle',
            'sectionSubtitle'
        ];
    }
}
