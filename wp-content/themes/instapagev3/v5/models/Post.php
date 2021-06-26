<?php
namespace Instapage\Models;

/**
 * Model for /blog page
 */
class Post {
  /**
   * Returns ID of page from which ACF fields for header section should be taken from
   * @return int
   */
  public function getContextID() {
    return get_option('page_for_posts');
  }

  /**
   * Gets excerpt from given post. Meant to replace buggy get_the_excerpt() when used outside `The Loop`
   * @param  int $postID
   * @return string Excerpt text
   */
  public static function getTheExcerpt($postID) {
    global $post;

    $temp = $post;
    $post = get_post($postID);
    setup_postdata($post);
    $excerpt = get_the_excerpt();
    wp_reset_postdata();
    $post = $temp;

    return $excerpt;
  }

  /**
   * Returns structured data for Google
   * @return string
   */
  public function getStructuredData() {
    global $post;

    $postCategories = displayPostCategoriesWithLinks(get_the_ID());

    $return = [];
    $return['headline'] = get_the_title();
    $return['dateModified'] = the_modified_date('c', null, null, false);
    $return['datePublished'] = ((!empty($postCategories)) && (stripos($postCategories, 'instapage-updates') !== false)) ? get_the_date('c') : the_modified_date('c', null, null, false);
    $return['author'] = get_the_author_meta('display_name');
    $return['image'] = getV5Src(get_the_ID());
    $return['imageWidth'] = 770;
    $return['imageHeight'] = 384;
    $return['logo'] = get_template_directory_uri() . '/v5/assets/images/logo.png';
    $return['logoWidth'] = 300;
    $return['logoHeight'] = 300;

    return $return;
  }

  /**
   * Get categories of current post and return their slug imploded with comma.
   *
   * @return string Slugs of categories of current post separated by comma.
   */
  public function getIpBlogCategories() {
    $categories = get_the_category();
    $resultString = '';

    foreach ($categories as $category) {
      // seperate slugs with comma
      if (!empty($resultString)) {
        $resultString .= ',';
      }

      $resultString .= $category->slug;
    }

    return $resultString;
  }
}
