<?php

namespace Instapage\Components\v70\PostsBrowser;

/**
 * Class holding posts types to show in posts browser component,
 * each post has label defined
 *
 * @package Instapage\Components\v70\PostsBrowser
 */
class PostTypes
{
    protected const DEFAULT = [
        'post' => [
            'label' => 'Blog'
        ],
        'webinar' => [
            'label' => 'Webinar'
        ],
        'video' => [
            'label' => 'Video Library'
        ],
        'podcast' => [
            'label' => 'Podcasts'
        ],
        'ebook' => [
            'label' => 'Ebooks'
        ],
        'seo-page' => [
            'label' => 'Marketing Guides'
        ],
        'dictionary-term' => [
            'label' => 'Marketing Dictionary'
        ],
        'customer-stories' => [
            'label' => 'Customer Stories'
        ]
    ];

    /**
     * Get human readable label for post type
     *
     * @param string $postType
     *
     * @return null|string
     */
    public static function getLabel(string $postType) : ?string
    {
        return self::DEFAULT[$postType]['label'] ?? null;
    }

    public static function getPostTypes() : array
    {
        return self::DEFAULT;
    }
}
