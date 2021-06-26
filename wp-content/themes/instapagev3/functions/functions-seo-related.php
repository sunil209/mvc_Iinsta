<?php

add_filter('wpseo_disable_adjacent_rel_links', function () {
  // when we return true for this filter
  // it will disable generating rel="next/prev" links by yoast
  return disableYoastRelLinksConditon();
});

add_action('wp_head', function() {
  addSearchActionSchema();
});

/**
 * YOAST FILTER
 * Leave only this users which has published
 * posts of post type post not in other post types.
 * Why?
 *
 * Because author archive list only posts with post type post.
 */
add_filter('wpseo_sitemap_exclude_author', function ($users) {
  return yoastLeaveUsersWhichHasPostsOnBlog($users);
});

/**
 * Function returns true if on current page there is no need to generate rel="next/prev" tags by yoast plugin.
 *
 * @global object $post
 * @return boolean
 */
function disableYoastRelLinksConditon() {
  global $post;
  $postType = $post->post_type;

  // conditions which have to be fullfield to disable generating rel="next" by yoast
  return !is_single() && ($postType === 'agency' || $postType === 'feature' || $postType === 'integration');
}


/**
 * Add search action schema only at homepage
 *
 * @return void
 */
function addSearchActionSchema() {
  if (is_front_page()) {
    ?>
    <script type="application/ld+json">
    {
       "@context": "http://schema.org",
       "@type": "WebSite",
       "url": "https://instapage.com/",
       "potentialAction": {
         "@type": "SearchAction",
         "target": "https://instapage.com/?s={search_term_string}",
         "query-input": "required name=search_term_string"
       }
    }
    </script>
    <?php
  }
}

/**
 * Leave only this users which has published
 * posts of post type post not in other post types.
 *
 * Used by 'wpseo_sitemap_exclude_author' filter.
 *
 * @param array $users Array of user objects to filter.
 *
 * @return array Filtered array of users
 */
function yoastLeaveUsersWhichHasPostsOnBlog($users) {
  // get user with pusblished posts on blog
  // post type = post
  $usersWithPublishedPostsOnBlog = get_users([
      'has_published_posts' => ['post']
  ]);

  /**
   * Create arrays intersection. Get only this users
   * from $users array from yoast which has post published on blog [$usersWithPublishedPostsOnBlog array].
   * Intersection is made based on user ID.
   */
  $filteredUsers = array_uintersect(
    $users,
    $usersWithPublishedPostsOnBlog,
    function ($user1, $user2) {
      return $user1->ID <=> $user2->ID;
    }
  );

  return $filteredUsers;
}
