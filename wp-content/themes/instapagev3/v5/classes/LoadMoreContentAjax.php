<?php

namespace Instapage\Classes;

/**
 * Class for loading more posts ajax andpoint handling
 */
class LoadMoreContentAjax
{
    /**
     * Activate load more ajax API endpoint, and do all initialization stuff
     *
     * @return void
     */
    public static function init()
    {
        add_action('wp_ajax_nopriv_load_more_content', [LoadMoreContentAjax::class, 'getMoreContent']);
        add_action('wp_ajax_load_more_content', [LoadMoreContentAjax::class, 'getMoreContent']);
    }

    /**
     * Controller of load more content api endpoint.
     *
     * Here is the beginning and here is the end of whole api call.
     *
     * @return void
     */
    public static function getMoreContent()
    {
        $result = [
            'posts' => [
                Component::fetch(
                    'listing',
                    'default',
                    [
                        'is_ajax' => true
                    ]
                )
            ]
        ];

        wp_send_json_success($result);
    }
}
