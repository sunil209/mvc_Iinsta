<?php
namespace Instapage\Components\v70\CtaSection;

use Instapage\Models\Component as ModelComponent;
use Instapage\Helpers\AcfHelper;

/**
 * Description of model-cta-section
 */
class CtaSectionModel extends ModelComponent
{
    public function getBackgroundLight() : bool
    {
        return (bool) get_field('cta_background_light', $this->isGlobalAcf());
    }

    public function getTitle() : string
    {
        return (string) get_field('cta_title', $this->isGlobalAcf());
    }

    public function getSubtitle() : string
    {
        return (string) get_field('cta_subtitle', $this->isGlobalAcf());
    }

    public function getSubtitleBottom() : string
    {
        return (string) get_field('cta_subtitle_bottom', $this->isGlobalAcf());
    }

    public function getButtons() : array
    {
        $buttons = [];

        while (have_rows('cta_buttons', $this->isGlobalAcf())) {
            the_row();
            $buttons[] = AcfHelper::parseButtonAttributes([
                'text' => get_sub_field('text'),
                'url' => get_sub_field('url'),
                'type' => get_sub_field('type'),
                'video' => get_sub_field('video')
            ]);
        }

        return $buttons;
    }

    /**
     * Check if template should load data from "Default component vaules" site for CTA section in "Custom site config"
     *
     * @return string|bool
     */
    private function isGlobalAcf()
    {
        if ($this->rawParams['isGlobalAcf']) {
            return 'option';
        }
        
        return (bool) get_field('cta_is_global', $this->contextID ?? false) === true ? 'option' : $this->contextID ?? false;
    }
    /**
     * Return list of parameters that model can provide.
     *
     * Remember that if paramter name is items, function which will fetch data for this parameter is getItems() etc.
     *
     * @return array Array containg parametes name that model can provide
     */
    public function getParamsListToInject() : array
    {
        return [
          'backgroundLight',
          'title',
          'subtitle',
          'subtitleBottom',
          'buttons'
        ];
    }
}
