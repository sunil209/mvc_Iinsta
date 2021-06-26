<?php
namespace Instapage\Components\v70\FeaturedArticle;

use Instapage\Models\Component;
use Instapage\Classes\Data;
use Instapage\Helpers\HtmlHelper;
use Instapage\Helpers\StringHelper;

/**
 * Model for featured-article component
 *
 */
class FeaturedArticleModel extends Component
{
    public function getSectionTitle() : string
    {
        return (string) get_field('featured_blog_article_section_title', $this->contextID);
    }

    public function getSectionSubtitle() : string
    {
        return (string) get_field('featured_blog_article_section_subtitle', $this->contextID);
    }

    public function getFeaturedArticles() : array
    {
        $articles = [];

        if (have_rows('featured_articles', $this->contextID)) {
            while (have_rows('featured_articles', $this->contextID)) {
                the_row();
                $featuredArticle = get_sub_field('featured_article');

                $postType = get_post_type($featuredArticle->ID);

                if (empty($featuredArticle)) {
                    return $articles;
                }

                $articles[] = [
                    'image' => HtmlHelper::getImgUlrIfSizeExists(
                        'v7-listing-size',
                        'v5-listing-size',
                        $featuredArticle->ID
                    ),
                    'image_retina' => HtmlHelper::getImgUlrIfSizeExists(
                        'v7-listing-size-retina',
                        'v5-listing-size-retina',
                        $featuredArticle->ID
                    ),
                    'excerpt' => StringHelper::truncate(
                        preg_replace('/\<a href\="([^"]+)" class\="excerpt-more"\>([^\<]+)\<\/a\>/', '', get_the_excerpt()),
                        125
                    ),
                    'title' => StringHelper::truncate($featuredArticle->post_title, 80),
                    'link' => get_permalink($featuredArticle->ID),
                    'postCategories' => get_the_category($featuredArticle->ID),
                    'authorID' => (int) $featuredArticle->post_author,
                    'authorName' => get_the_author_meta('display_name', $featuredArticle->post_author),
                    'disableLink' => !hasAuthorPosts(get_the_author_meta('ID', $featuredArticle->post_author)),
                    'moreText' => 'Read more',
                    'isFeaturedArticle' => true,
                    'isAuthor' => $this->getIsAuthor($postType)
                ];
            }
        }

        return $articles;
    }

    public function getIsAuthor(string $postType): bool
    {
        return $postType === 'post';
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
            'featuredArticles'
        ];
    }
}
