<?php

namespace Instapage\Components\v70\TestimonialsSliderNew;

use Instapage\Models\Component;

class TestimonialsSliderNewModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('testimonial_slider_section_title');
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_field('testimonial_slider_section_subtitle');
    }

    public function getSlides() : array
    {
        return (array) get_field('testimonials_slides', $this->isGlobalAcf());
    }

    /**
     * Check if template should load data from "Default component vaules" site for Testimonials slider in "Custom site config"
     *
     * @return string|bool
     */
    private function isGlobalAcf()
    {
        return (bool) get_field('testimonials_slider_is_global') === true ? 'option' : false;
    }

    public function getParamsListToInject() : array
    {
        return [
            'sectionTitle',
            'sectionSubtitle',
            'slides'
        ];
    }
}
