<?php
namespace Instapage\Models\SiteMap;

use Instapage\Models\SiteMap\SiteMapItem;
use Instapage\Models\SiteMap;

/**
 * Seciton of sitemap
 *
 * @uses \Instapage\Models\SiteMap\SiteMapItem For storing item of sitemap
 */
class SiteMapSection {
  /**
   * Names of all needed acf fields to fetch data for SiteMapSection
   */
  const ACF_FIELDS = [
    'customSectionsLayout' => 'custom_section',
    'customLinksReapeater' => 'links',
    'searchType' => 'advanced_search',
    'simpleLink' => 'link_to_content_simple',
    'advancedLink' => 'link_to_content_advanced',
    'linkName' => 'link_name',
    'listAllPostsLayout' => 'list_all_posts',
    'postType' => 'insta_custom_choose_post_type',
    'customLink' => 'custom_link'
  ];

  /**
   * @var string Name of section
   */
  public $sectionName;

  /**
   * @var SiteMapItem[] Array of items in this sitemap section
   */
  public $items = [];

  /**
   * Creates site map section.
   *
   * @param string $sectionName Name of section to create, wil be used in the view.
   *
   * @return void
   */
  public function __construct(string $sectionName = '') {
    $this->sectionName = $sectionName;
  }

  /**
   * Build sitemap section from ACF.
   *
   * Note that this function must be called from proper acf context.
   *
   * @param string $sectionLayout
   */
  public function buildFromACF(string $sectionLayout = '') {
    switch ($sectionLayout) {
      case self::ACF_FIELDS['customSectionsLayout']:
        $this->fetchLinksFromCustomSection();
        break;
      case self::ACF_FIELDS['listAllPostsLayout']:
        $this->fetchAllCustomPostTypeLinks();
        break;
    }
  }

  /**
   * Fetch all links to post of given custom post type.
   *
   * This is useful when we want put all posts from custom post type to
   * our sitemap.
   */
  protected function fetchAllCustomPostTypeLinks() {
    $postType = get_sub_field(self::ACF_FIELDS['postType']);

    $queryArg = [
      'post_type' => $postType,
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'orderby' => 'title',
      'order'   => 'ASC',
    ];

    $query = new \WP_Query($queryArg);

    foreach ($query->posts as $post) {
      $this->addItem(new SiteMapItem(
        $post->post_title,
        get_permalink($post->ID)
      ));
    }
  }

  /**
   * Parse link from advanced selector of content
   *
   * @return string
   */
  protected function parseAdvancedLink() : string {
    $url = '';
    $posts = get_sub_field(self::ACF_FIELDS['advancedLink']);

    if ($posts) {
      // we know from domain knowledge that we have here only one post choosed [resrtriction on acf]
      $url = (string) get_permalink($posts[0]->ID);
    }

    return $url;
  }

  /**
   * Parse custom link
   *
   * Custom link can have simple or advanced selector - treated differentially.
   */
  protected function parseLinkFromCustomSection() {
    $url = '';
    $searchType = get_sub_field(self::ACF_FIELDS['searchType']);

    if ($searchType === 'Simple') {
      $url = (string) get_sub_field(self::ACF_FIELDS['simpleLink']);
    } else if ($searchType === 'Advanced') {
      $url = $this->parseAdvancedLink();
    } else if ($searchType === 'Custom') {
      $url = (string) get_sub_field(self::ACF_FIELDS['customLink']);
    }

    $this->addItem(new SiteMapItem(
      (string) get_sub_field(self::ACF_FIELDS['linkName']),
      $url
    ));
  }

  /**
   * Fetch all link from custom section layout.
   *
   * Layout made with use of ACF.
   */
  protected function fetchLinksFromCustomSection() {
    if (have_rows(self::ACF_FIELDS['customLinksReapeater'])) {
      while (have_rows(self::ACF_FIELDS['customLinksReapeater'])) {
        the_row();
        $this->parseLinkFromCustomSection();
      }
    }
  }

  /**
   * Add item to the section
   *
   * @param SiteMapItem Single item of sitemap
   *
   * @return void
   */
  public function addItem(SiteMapItem $item) {
    $this->items[] = $item;
    return $this;
  }
}
