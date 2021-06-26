<?php

namespace Instapage\Components\v70\PostsBrowser;

use Instapage\Classes\Factory;
use Instapage\Models\Component;
use Instapage\Components\v70\Listing\ListingModel;

class PostsBrowserModel extends Component
{
    private const DEFAULT_POSTS_NUMBER = 4;

    public function getPostsFromPostType(string $postType, int $postCount) : array
    {
        $query = new \WP_Query(
            [
                'post_type' => $postType,
                'post__not_in' => $this->getExcludedPost(),
                'posts_per_page' => $postCount,
                'ignore_sticky_posts' => true,
            ]
        );
        
        return $query->posts;
    }

    /**
     * Get Posts collection to show in post browser
     *
     * @return array
     */
    public function getAllPosts() : array
    {
        $posts = [];

        foreach (\array_keys($this->getPostTypes()) as $postType) {
            if ($postType === 'seo-page') {
                $options['posts_per_page'] = 4;
                $modifyGlobalQuery = false;
                $posts[$postType] = Factory::getModel('seo-page')->getPosts($options, $modifyGlobalQuery);
            } else {
                $posts[$postType] = $this->getPostsFromPostType(
                    $postType,
                    $this->getPostsCount()
                );
            }
        }

        return $posts;
    }

    /**
     * How many posts we should to return for each post type,
     * it has default settings if not provided
     *
     * @return int
     */
    public function getPostsCount() : int
    {
        return $this->rawParams['postCount'] ?? self::DEFAULT_POSTS_NUMBER;
    }

    /**
     * Get array of post types that you want show in posts-browser
     *
     * @return array
     */
    public function getPostTypes() : array
    {
        return $this->rawParams['postTypes'] ?? PostTypes::getPostTypes();
    }

    /**
     * Get array of post types' labels that you want show in posts-browser slider navigation
     *
     * @return array
     */
    public function getPostTypesLabels() : array
    {
        $postTypesLabels = [];
        foreach ($this->getPostTypes() as $postType) {
            $postTypesLabels[] = ['name' => $postType['label']];
        }
        return $postTypesLabels;
    }

    /**
     * Get ListingModel to use its methods for post type panels
     *
     * @return object
     */
    public function getListingModel() : ListingModel
    {
        $listingModel = new ListingModel();
        return $listingModel;
    }

    /**
     * Get Post array which need to be excluded from the listing.
     *
     * @return array
     */
    public function getExcludedPost() : array
    {
        return (array) get_field( 'custom_exclude_post' , 'options' );
    }

    /**
     * Let know which parameters model is able to provide
     *
     * @return array
     */
    public function getParamsListToInject() : array
    {
        return [
            'allPosts',
            'postTypesLabels',
            'listingModel'
        ];
    }
}
