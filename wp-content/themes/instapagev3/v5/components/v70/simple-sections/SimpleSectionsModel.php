<?php
namespace Instapage\Components\v70\SimpleSections;

use Instapage\Models\IteratorComponent;
use Instapage\Helpers\AcfHelper;

/**
 * Model for simple-sections component
 *
 */
class SimpleSectionsModel extends IteratorComponent
{
    public function getTitle() : string
    {
        return (string) get_sub_field('title');
    }
    public function getSubtitle() : string
    {
        return (string) get_sub_field('subtitle');
    }

    public function getButton() : array
    {
        $button = [];

        if (have_rows('button')) {
            while (have_rows('button')) {
                the_row();
                $button = AcfHelper::parseButtonAttributes([
                    'text' => get_sub_field('text'),
                    'url' => get_sub_field('url'),
                    'type' => get_sub_field('type'),
                    'video' => get_sub_field('video')
                ]);
            }
        }

        return (array) $button;
    }

    public function getImage() : array
    {
        return (array) get_sub_field('image');
    }

    public function getImageRetina() : array
    {
        return (array) get_sub_field('image_retina');
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
            'subtitle',
            'button',
            'image',
            'imageRetina'
        ];
    }
}
