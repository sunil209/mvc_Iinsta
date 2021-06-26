<?php
namespace Instapage\Components\v70\News;

use Instapage\Models\Component;

/**
 * Model for news component
 *
 */
class NewsModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('news_section_title');
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_field('news_section_subtitle');
    }

    public function getNews() : array
    {
        return (array) get_field('news');
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
            'news'
        ];
    }
}
