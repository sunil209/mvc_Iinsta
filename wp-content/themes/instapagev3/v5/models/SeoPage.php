<?php
namespace Instapage\Models;

/**
 * Model for /resources/guides page
 */
class SeoPage extends Root
{
    /**
     * @var number $postPerPage Set how many post we should have by one page
     */
    const POST_PER_PAGE = 10;

    /**
     * @var string $postType Holds information about what postType should be used with this model
     */
    public $postType = 'seo-page';

    /**
     * Returns ID of page from which ACF fields for header section should be taken from
     *
     * @return int
     */
    public function getContextID()
    {
        return get_page_by_path('guides');
    }

    /**
     * Returns post category name
     *
     * @param  int $postID
     *
     * @uses   getVar()
     * @return string Category name
     **/
    public function getPostCategoryName($postID)
    {
        $terms = get_the_terms($postID, 'seo_section');

        return getVar($terms[0]->name, '');
    }

    /**
     * Returns chapter number
     *
     * @param  WP_Post $post post object.
     *
     * @uses   getVar()
     * @return int number of chapter.
     */
    public function getPostChapterNumber(\WP_Post $post)
    {
        $pattern = '/-chapter-([0-9]+)/';
        $matches = [];
        preg_match($pattern, $post->post_name, $matches);

        return getVar($matches[1], 0);
    }

    /**
     * Returns intro chapter link for given post
     *
     * @param  WP_Post $post post object
     *
     * @uses   self::getPostChapterNumber()
     * @return string
     */
    public function getPostIntroChapterLink(\WP_Post $post)
    {
        $chapterNumber = (int)$this->getPostChapterNumber($post);

        return ($chapterNumber > 0) ? substr($post->post_name, 0,
            strpos($post->post_name, '-chapter-')) : $post->post_name;
    }

    /**
     * Pulls the list of post slides for archive page header.
     *
     * @param  int $limit Limit of posts.
     *
     * @uses   self::$postType
     * @uses   \Instapage\Models\Root::getPostSlides()
     * @uses   self::getPostChapterNumber()
     * @uses   self::getPostCategoryName()
     * @return array List of post slides in proper format.
     */
    public function getPostSlides($postType = 'seo-page', $limit = 3)
    {
        $items  = [];
        $slides = parent::getPostSlides($this->postType, -1);

        if ( ! empty($slides)) {
            foreach ($slides as $slide) {
                if (
                    $this->getPostChapterNumber(get_post($slide['ID'])) === 0
                    && $slide['image'] !== ''
                ) {
                    $slide['title'] = $this->getPostCategoryName($slide['ID']);
                    $items[]        = $slide;
                }
            }
        }

        return array_slice($items, 0, $limit);
    }

    /**
     * Function useful for knowing if pagination is out of range.
     *
     * @return int Return max page number for guides
     */
    public function getMaxPageNumberInPagination()
    {
        // get all posts without all pagination stuff
        $posts = $this->getPosts([
            'posts_per_page' => -1
        ], $modifyGlobalQuery = false);

        $postsNumber = count($posts);
        if ($postsNumber > 0) {
            return ceil($postsNumber / self::POST_PER_PAGE);
        }

        return 1;
    }

    /**
     * Gets list of posts matching given criteria
     *
     * @param  array  $options           Array which will be merged with default values and passed down to get_posts()
     * @param  bolean $modifyGlobalQuery By default method use global query object - wordpress native pagination utilize global query object, but for sitemap we have to use new WP_QUERY object
     *
     * @uses   \Instapage\Models\Root::getPosts()
     * @uses   self::getPostChapterNumber()
     * @uses   self::getPostCategoryName()
     * @uses   \Instapage\Models\Post::getTheExcerpt()
     * @return array
     */
    public function getPosts($options = [], $modifyGlobalQuery = true)
    {
        /**
         * For sitemap global $wp_query object is wrongly preset for homepage,
         * so we create new one by setting flag $modifyGlobalQuery to true
         */
        if ($modifyGlobalQuery) {
            global $wp_query;
        } else {
            $wp_query = new \WP_Query;
        }

        $items = [];

        $optionsDefault = [
            'post_type'          => $this->postType,
            'post_status'        => 'publish',
            'post_name_not_like' => '-chapter-',
            'custom_pagination'  => true,
            'posts_per_page'     => self::POST_PER_PAGE,
        ];

        $options = array_merge($optionsDefault, $options);

        // in case of seo page fetching posts we do not want to suppress filteres,
        // filters are cool and we need them to suppor post_name_not_like functionality
        $options['suppress_filters'] = false;
        foreach ($options as $key => $value) {
            $wp_query->set($key, $value);
        }
        $posts = $wp_query->get_posts();

        if ((is_array($posts)) && ( ! empty($posts))) {
            foreach ($posts as $post) {
                $post->title     = $this->getPostCategoryName($post->ID);
                $post->excerpt   = Post::getTheExcerpt($post->ID);
                $post->permalink = get_permalink($post);
                $items[]         = $post;
            }
        }

        return $items;
    }

    /**
     * Map seo page chapters to input format of v51/quick-links component
     *
     * @param array $chapters Array of posts containing chapters of seo guide
     *
     * @return array
     */
    public static function mapChaptersToQuickLinks(array $chapters): array
    {
        return array_map(function ($chapter) {
            return [
                'href'       => '#chapter-' . getChapterNr($chapter),
                'title'      => $chapter->post_title,
                'attributes' => [
                    'data-scroll' => 0
                ]
            ];
        }, $chapters);
    }
}
