<?php
namespace Instapage\Components\v70\Header;

use Instapage\Models\Component as ModelComponent;
use Instapage\Helpers\AcfHelper;

class HeaderModel extends ModelComponent
{
    public function getImage(): array
    {
        return (array) get_field('header_img', $this->contextID ?? false)['regular'];
    }

    public function getImageRetina(): array
    {
        return (array) get_field('header_img', $this->contextID ?? false)['retina'];
    }

    public function getMultipleImageOptions(): array
    {
        return (array) get_field('header_img', $this->contextID ?? false)['images'];
    }

    public function getIsMultipleImage(): bool
    {
        return (bool) get_field('header_img', $this->contextID ?? false)['multiple_image'];
    }

    public function getIsImageBackground(): bool
    {
        return (bool) get_field('header_img', $this->contextID ?? false)['background'];
    }

    public function getIsLayoutCenter(): bool
    {
        return (bool) get_field('header_layout_center', $this->contextID ?? false);
    }

    public function getIsLayoutShort(): bool
    {
        return (bool) get_field('header_layout_short', $this->contextID ?? false);
    }

    public function getIsLayoutLight(): bool
    {
        return (bool) get_field('header_layout_light', $this->contextID ?? false);
    }

    public function getLabel(): string
    {
        return (string) get_field('header_copy_label', $this->contextID ?? false);
    }

    public function getTitle(): string
    {
        return (string) get_field('header_copy_title', $this->contextID ?? false);
    }

    public function getSubtitle(): string
    {
        return (string) get_field('header_copy_subtitle', $this->contextID ?? false);
    }

    public function getButtons() : array
    {
        $buttons = [];
        while (have_rows('header_copy_buttons', $this->contextID ?? false)) {
            the_row();
            $buttons[] = AcfHelper::parseButtonAttributes([
              'text' => get_sub_field('text', $this->contextID ?? false),
              'url' => get_sub_field('url', $this->contextID ?? false),
              'type' => get_sub_field('type', $this->contextID ?? false),
              'video' => get_sub_field('video', $this->contextID ?? false)
            ]);
        }

        return $buttons;
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
        'image',
        'imageRetina',
        'multipleImageOptions',
        'isMultipleImage',
        'isImageBackground',
        'isLayoutCenter',
        'isLayoutShort',
        'isLayoutLight',
        'label',
        'title',
        'subtitle',
        'buttons'
        ];
    }
}
