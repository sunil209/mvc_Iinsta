<?php

namespace Instapage\Components\v70\ProductFeaturesSlider;

use Instapage\Models\Component;

class ProductFeaturesSliderModel extends Component
{
    public function getTitle() : string
    {
        return (string) get_field('product_features_sliders_section_title');
    }

    public function getSubtitle() : string
    {
        return (string) get_field('product_features_sliders_section_subtitle');
    }

    public function getSlides() : array
    {
        return (array) get_field('product_features_slides');
    }

    public function getParamsListToInject() : array
    {
        return [
            'title',
            'subtitle',
            'slides'
        ];
    }
}
