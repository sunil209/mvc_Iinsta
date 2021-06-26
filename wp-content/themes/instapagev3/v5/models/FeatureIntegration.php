<?php
namespace Instapage\Models;

/**
 * Base model for /integrations and /features pages
 */
abstract class FeatureIntegration extends Root
{
    /**
     * @var string $postType Holds information about what postType should be used with this model
     */
    public $postType;

    /**
     * @var string $relatedTaxonomy Holds name of related taxonomy
     */
    public $relatedTaxonomy;

    /**
     * @var string $relatedPage Holds name of related page containing required ACF fields
     */
    public $relatedPage;

    /**
     * Returns ID of page which ACF fields for header section should be taken from
     * @return int
     */
    public function getContextID()
    {
        return get_page_by_path($this->relatedPage);
    }

    /**
     * Gets the terms of a selected taxonomy.
     * @param  string $taxonomy Name of the taxonomy. Default: 'category'.
     * @param  array $args Additional arguments passed to get_categories functiom.
     * @uses   parent::getTaxonomy()
     * @return array Terms for selected taxonomy.
     */
    public function getTaxonomy($taxonomy = 'category', $args = [])
    {
        $terms = call_user_func(
            [
                'parent',
                __FUNCTION__
            ],
            $taxonomy,
            array_merge(
                $args,
                [
                'orderby' => 'term_id',
                'order' => 'ASC'
                ]
            )
        );
        if (!empty($terms)) {
            foreach ($terms as &$term) {
                $term['url'] = '#term-' . sanitize_title_with_dashes($term['name']);
            }
            unset($term);
        }

        return $terms;
    }

    /**
     * Gets single testimonial data from ACF.
     * If name is empty, thus testimonial should not be displayed - returns an empty array
     * @param  int $postID ID of post ACF data should be pulled from
     * @return array Data of single testimonial or empty array
     */
    public function getTestimonial($postID)
    {
        $data = array_combine(
            ['avatar', 'comment', 'name', 'position', 'company'],
            getAcfVars(
                ['avatar', 'comment', 'name', 'position', 'company'],
                ['', '', '', '', ''],
                $postID
            )
        );

        if (empty($data['name'])) {
            return [];
        }

        return $data;
    }

    /**
     * Decides whether to display given post in given category.
     * Remember that single post can be displayed in multiple categories
     * @param  int $postID ID of post
     * @param  string $taxonomy Taxonomy name
     * @param  array $category Single element from array taken from self::getTaxonomy()
     * @return bool Returns true if given post should be displayer in given category
     */
    public function hasTaxonomy($postID, $taxonomy, $category)
    {
        $terms = wp_get_post_terms($postID, $taxonomy);

        if (empty($terms)) {
            return false;
        }

        foreach ($terms as $term) {
            if ($term->name === $category['name']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns data in format ready for `v51/accordion` component
     * @uses   self::$relatedTaxonomy
     * @uses   self::getTaxonomy()
     * @uses   self::hasTaxonomy()
     * @uses   self::getPosts()
     * @return array
     */
    public function getAccordions()
    {
        global $wp_embed;

        $accordions = [];

        $categories = $this->getTaxonomy($this->relatedTaxonomy);
        $posts = $this->getPosts();
        if ((isset($categories)) && (!empty($categories))) {
            foreach ($categories as $category) {
                $accordion = [
                    'headline' => $category['name'],
                    'groupID' => $category['id']
                ];
                foreach ($posts as $post) {
                    if ($this->hasTaxonomy($post->ID, $this->relatedTaxonomy, $category)) {
                        $accordion['items'][] = [
                            'title' => $post->post_title,
                            'excerpt' => $post->post_excerpt,
                            'url' => (!empty($post->post_content)) ? get_permalink($post->ID) : '',
                            'icon' => getAcfVar('icon', '', $post->ID),
                            'is_open' => getAcfVar('is_expanded', false, $post->ID),
                            'videoEmbedCode' => has_post_video($post->ID) ? $wp_embed->run_shortcode('[embed]' . get_the_post_video_url($post->ID) . '[/embed]') : '',
                            'attributes' => [
                                'id' => 'term-' . sanitize_title_with_dashes($post->post_title)
                            ],
                            'tags' => getAcfVar('integrations_tags', [], $post->ID)
                        ];
                    }
                }
                $accordions[] = $accordion;
            }
        }

        return $accordions;
    }
}
