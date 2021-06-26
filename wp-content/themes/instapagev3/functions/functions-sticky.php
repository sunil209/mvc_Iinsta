<?php
/**
 * Class used for `sticky posts` feature in custom post types
 */
class StickyPosts {

    /**
     * @var array $supportedPostTypes Holds an array of post types which archive pages will be modified to use sticky posts feature. Note that you'll have also add relevant post types to ACF group called `Sticky posts`
     **/
    private $supportedPostTypes = ['ebook', 'video', 'podcast'];

    public function __construct() {
        add_action('pre_get_posts', [$this, 'hook']);
    }

    /**
     * Hook called by `pre_get_posts` action
     * @param WP_Query $query Global WP_Query class instance
     */
    public function hook($query) {
        if (!is_admin() && $query->is_main_query() && is_post_type_archive($this->supportedPostTypes)) {
            $query->set('meta_key', 'sticky');
            $query->set(
              'orderby',
              [
                'meta_value_num' => 'DESC',
                'menu_order' => 'ASC'
              ]
            );
        }
    }
}

new StickyPosts();
