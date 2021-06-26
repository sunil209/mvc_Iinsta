<?php

namespace Instapage\Models;

/**
 * Model for podcasts
 */
class Podcast
{
    /**
     * Get contextID for podcast listing.
     *
     *
     * @return string $param
     */
    public function getContextID()
    {
        return get_page_by_path('podcast');
    }
}
