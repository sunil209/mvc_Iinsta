<?php
namespace Instapage\Components\v70\Listing;

use Instapage\Classes\{
    Data,
    InstapageWpFilters
};
use Instapage\Helpers\HtmlHelper;
use Instapage\Helpers\StringHelper;
use Instapage\Models\Component;
use Instapage\Models\Root;

/**
 * Model for benefits section
 */
class ListingModel extends Component
{
    /** @var \WP_Query*/
    protected $wpQuery;

    private const BUTTON_TEXT_FOR_POST_TYPE = [
        'post' => 'READ MORE',
        'video' => 'WATCH NOW',
        'webinar' => 'VIEW NOW',
        'podcast' => 'SEE THE FULL STORY'
    ];
    private const BUTTON_VIDEO_FOR_POST_TYPE = [
        'video' => 'play_arrow'
    ];

    public function getPosts(): array
    {
        $posts = [];
        $query = $this->getQueryForCurrentRequest();

        while ($query->have_posts()) {
            $query->the_post();
            $posts[] = $this->getListingData($query->post);
        }

        return $posts;
    }

    public function getQueryForCurrentRequest(): \WP_Query
    {
        if ($this->wpQuery instanceof \WP_Query) {
            return $this->wpQuery;
        }

        return $this->wpQuery = $this->getQuery($this->prepareQueryParams());
    }

    public function getAuthorId(): ?int
    {
        return is_author() ? (int)get_the_author_meta('ID') : null;
    }

    public function getPostTypes(): array
    {
        $postType = get_query_var('post_type');

        if (empty($postType)) {
            $postType = get_post_type();
        }

        return (array) $postType;
    }

    public function getCurrentPageNumber(): int
    {
        return get_query_var('paged') !== 0 ? (int) get_query_var('paged') : 1;
    }

    public function getMaxPageNumber(): int
    {
        $wpQuery = $this->getQueryForCurrentRequest();

        return $wpQuery->max_num_pages;
    }

    public function getCategoryName(): string
    {
        return get_query_var('category_name') ?? '';
    }

    public function getCategories(): array
    {
        $postTypes = $this->getPostTypes();

        $categories =  [];
        if (count($postTypes) === 1 && $postTypes[0] === 'post') {
            $categories = [
                'all' => Root::getTaxonomy(),
                'current' => 'All Categories'
            ];

            foreach ($categories['all'] as $category) {
                if (stripos($category['url'], $_SERVER['REQUEST_URI']) !== false) {
                    $categories['current'] = $category['name'];
                    break;
                }
            }
        }

        return $categories;
    }

    public function getSearchQuery(): ?string
    {
        return is_search() ? get_search_query() : null;
    }

    public function prepareQueryParams(): array
    {
        $params = [
            'pageNumber' => intval(Data::_get('pageToLoadNumber', null, FILTER_SANITIZE_NUMBER_INT)),
            'postTypes' => filter_input(INPUT_GET, 'postTypesToLoad', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY),
            'authorID' => intval(Data::_get('authorID', null, FILTER_SANITIZE_NUMBER_INT)),
            'categoryName' => Data::_get('categoryName', $this->getCategoryName(), FILTER_SANITIZE_STRING),
            'searchQuery' => Data::_get('searchQuery', $this->getSearchQuery(), FILTER_SANITIZE_STRING)
        ];

        if ($params['postTypes'] === null) {
            $params['postTypes'] = $this->getPostTypes();
        }

        $params['authorID'] = $params['authorID'] !== 0 ? $params['authorID'] : $this->getAuthorId();
        $params['pageNumber'] = $params['pageNumber'] !== 0 ? $params['pageNumber'] : $this->getCurrentPageNumber();

        return $params;
    }

    public function getQuery(array $requestData): \WP_Query
    {
        $queryArgs = [
            'post_type' => $requestData['postTypes'],
            'post_name_not_like' => '-chapter-',
            'paged' => $requestData['pageNumber'],
            'posts_per_page' => get_option('posts_per_page'),
            'post_status' => 'publish',
            'post__not_in' => $this->getExcludedPost(),
            'orderby' =>
                [
                    'meta_value_num' => 'DESC',
                    'menu_order' => 'ASC'
                ],
            'ignore_sticky_posts' => true
        ];

        $queryArgs = $this->excludePostsFunctionality($queryArgs);

        // if this is author listing page ask only for posts of this author
        if (is_int($requestData['authorID'])) {
            $queryArgs['author'] = $requestData['authorID'];
        }

        // if this is category listing page ask only for posts of given category
        if (!empty($requestData['categoryName'])) {
            $queryArgs['category_name'] = $requestData['categoryName'];
        }

        // if this is search result listing page ask only for posts of search query
        if (!empty($requestData['searchQuery'])) {
            $queryArgs['s'] = $requestData['searchQuery'];
        }

        $posts = new \WP_Query(
            apply_filters(
                InstapageWpFilters::V7_LISTING_WP_QUERY,
                $queryArgs
            )
        );

        return $posts;
    }

    public function getListingData(\WP_Post $post = null) : array
    {
        $post = $post ?? get_post();
        $postType = get_post_type($post->ID);
        return [
            'image' => HtmlHelper::getImgUlrIfSizeExists(
                'v7-listing-size',
                'v5-listing-size',
                $post->ID
            ),
            'image_retina' => HtmlHelper::getImgUlrIfSizeExists(
                'v7-listing-size-retina',
                'v5-listing-size-retina',
                $post->ID
            ),
            'excerpt' => StringHelper::truncate(
                preg_replace('/\<a href\="([^"]+)" class\="excerpt-more"\>([^\<]+)\<\/a\>/', '', get_the_excerpt($post->ID)),
                125
            ),
            'title' => StringHelper::truncate(get_the_title($post->ID), 80),
            'link' => get_permalink($post->ID),
            'postCategories' => get_the_category($post->ID),
            'authorID' => (int) $post->post_author,
            'authorName' => get_the_author_meta('display_name', $post->post_author),
            'disableLink' => !hasAuthorPosts($post->post_author),
            'moreText' => $this->getMoreTextButton($postType),
            'isVideoButton' => $this->getVideoButton($postType),
            'isAuthor' => $this->getIsAuthor($postType),
            'isSoundcloud' => $this->isPodcast($postType)
        ];
    }

    protected function excludePostsFunctionality($wpQueryArgs): array
    {
        $acfFieldName = 'is_excluded_from_listing';

        return array_merge($wpQueryArgs, [
            'meta_query' =>
                [
                    'relation' => 'OR',
                    [
                        'key' => $acfFieldName,
                        'compare' => 'NOT EXISTS',
                        'value' => '0' // there has to be something, wp bug #23268
                    ],
                    [
                        'key' => $acfFieldName,
                        'compare' => '!=',
                        'value' => '1'
                    ]
                ]
        ]);
    }

    /**
    * Get Post array which need to be excluded from the listing.
    *
    * @return array
    */
    private function getExcludedPost() : array
    {
        return (array) get_field( 'custom_exclude_post' , 'options' );
    }

    private function getMoreTextButton(string $postType): string
    {
        return self::BUTTON_TEXT_FOR_POST_TYPE[$postType] ?? 'READ MORE';
    }

    private function getVideoButton(string $postType): string
    {
        return self::BUTTON_VIDEO_FOR_POST_TYPE[$postType] ?? '';
    }

    public function getIsAuthor(string $postType): bool
    {
        return $postType === 'post' || $postType === 'seo-page';
    }

    public function isPodcast(string $postType): bool
    {
        return $postType === 'podcast';
    }

    /**
     * Method from abstract class telling which info model can generate
     *
     * @return array
     */
    public function getParamsListToInject(): array
    {
        return [
            'posts',
            'currentPageNumber',
            'maxPageNumber',
            'categories',
            'categoryName',
            'postTypes',
            'authorId',
            'searchQuery'
        ];
    }
}
