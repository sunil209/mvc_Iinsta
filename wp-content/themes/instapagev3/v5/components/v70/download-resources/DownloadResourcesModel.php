<?php
namespace Instapage\Components\v70\DownloadResources;

use Instapage\Models\Component;

/**
 * Model for download-resources component
 *
 */
class DownloadResourcesModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('download_resources_section_title');
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_field('download_resources_section_subtitle');
    }

    public function getResources() : array
    {
        return (array) get_field('download_resources');
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
            'resources'
        ];
    }
}
