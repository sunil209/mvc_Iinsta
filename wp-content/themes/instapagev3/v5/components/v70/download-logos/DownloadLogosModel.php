<?php
namespace Instapage\Components\v70\DownloadLogos;

use Instapage\Models\Component;

/**
 * Model for download-logos component
 *
 */
class DownloadLogosModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('download_logos_section_title');
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_field('download_logos_section_subtitle');
    }

    public function getLogos() : array
    {
        return (array) get_field('logos_assets');
    }

    public function getAssets() : array
    {
        return (array) get_field('download_assets');
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
            'logos',
            'assets'
        ];
    }
}
