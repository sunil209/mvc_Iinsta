<?php
add_action( 'init', 'registerPodcastPosttype', 1 );
add_filter( 'excerpt_more', 'podcastExcerptMore' );

function registerPodcastPosttype()
{
  $post_type = 'podcast';

  $labels = array(
    'name' => __( 'Podcasts' ),
    'singular_name' => __( 'Podcast' ),
    'add_new_item' => __( 'Add new podcast' ),
    'edit_item' => __( 'Edit podcast' ),
    'new_item' => __( 'New podcast' ),
    'view_item' => __( 'View podcast' ),
    'search_items' => __( 'Search podcasts' ),
    'not_found' => __( 'No podcasts' ),
  );

  $supports = array(
    'title',
    'revisions',
    'editor',
    'excerpt',
    'thumbnail',
    'page-attributes'
  );

  $rewrite = array(
    'with_front' => false,
    'slug' => $post_type,
    'feeds' => false,
    'pages' => true
  );

  $args = array(
    'labels' => $labels,
    'supports' => $supports,
    'rewrite' => $rewrite,
    'exclude_from_search' => false,
    'hierarchical' => true,
    'public' => true,
    'has_archive' => true,
    'capability_type' => array( 'podcast', 'podcasts' ),
    'capabilities' => array(
      'read_post' => 'read_podcast',
      'publish_posts' => 'publish_podcasts',
      'edit_posts' => 'edit_podcasts',
      'edit_others_posts' => 'edit_others_podcasts',
      'delete_posts' => 'delete_podcasts',
      'delete_others_posts' => 'delete_others_podcasts',
      'read_private_posts' => 'read_private_podcasts',
      'edit_post' => 'edit_podcast',
      'delete_post' => 'delete_podcast',
     ),
    'map_meta_cap' => true,
    'menu_icon' => get_template_directory_uri() . '/v5/assets/images/soundcloud-icon-grey.svg' );

  register_post_type( $post_type, $args );
}

function isPodcast()
{
  $post = get_post();

  if( !$post || $post->post_type != 'podcast' )
  {
    return false;
  }

  return true;
}

function getPodcastSoundcloudEmbed( $post_id = null)
{
  if( !$post_id )
  {
    $post_id = get_the_ID();
  }

  $soundcloud_shortcode = get_post_meta( $post_id, 'soundcloud_embed_code', true );

  return apply_filters( 'the_content', $soundcloud_shortcode );
}

function getUpcomingPodcastsCounter()
{
  $args = array(
    'nopaging' => true,
    'post_type' => 'podcast',
    'post_status' => 'publish',
    'fields' => 'ids',
    'meta_query' => array(
      array(
        'key' => 'upcoming',
        'value' => true
      )
    )
  );

  $podcasts = get_posts( $args );

  return count( $podcasts );
}

add_action('pre_get_posts', function (\WP_Query $query) {
  // modify main query only for podcast
  // do not alter admin queries
  // and do it only for main query
  if (!$query->is_main_query() || is_admin() || !is_post_type_archive('podcast')) {
    return;
  }

  // Get original meta query
  $metaQuery = $query->get('meta_query');

  // Add our meta query to the original meta queries
  // This meta query do not list upcoming pdocastr in podcast listing
  $additionalMetaQuery = [
      'key' => 'upcoming',
      'value' => true,
      'compare' => '!='
  ];

  // merge with other metaQuery settings, if there were
  if (is_array($metaQuery)) {
    $metaQuery[] = $additionalMetaQuery;
  } else {
    $metaQuery = $additionalMetaQuery;
  }

  // and alter query
  $query->set('meta_query',$metaQuery);
});

function podcastExcerptMore( $more )
{
  global $post;

  if( isPodcast() )
  {
    return '<a href="'. get_permalink($post->ID) . '" class="excerpt-more">' . __( 'See the full story here' ) . '</a>';
  }

  return $more;
}
