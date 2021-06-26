<?php

use \Instapage\Classes\InstapageWpFilters;

add_filter('post_link', 'filterSeoPagesLink', 10, 3);
add_filter('post_type_link', 'filterSeoPagesLink', 10, 3);
add_action('init', 'registerSeoPagesTaxonomy', 1);
add_action('init', 'registerSeoPagePosttype', 2);
add_action('init', 'seoPagesEditorStyles');
add_action('pre_get_posts', 'seoPagesEditorStyles');
add_filter('manage_seo-page_posts_columns', 'setCustomSeoPagesColumns');
add_action('manage_seo-page_posts_custom_column', 'customSeoPageColumn', 10, 2);
add_filter('wpseo_og_og_title', 'instapageSeoPageSocialShareTitle');
add_filter('wpseo_twitter_title', 'instapageSeoPageSocialShareTitle');
add_filter('wpseo_opengraph_image', 'socialImage');
add_filter('wpseo_twitter_image', 'socialImage');
add_action('restrict_manage_posts', 'seoPagesPostFilterRestrictPosts');
add_filter('parse_query', 'seoPagesPostFilter');
add_filter('posts_where', 'seoPagesChaptersFilter', 10, 2);
add_filter('posts_where', 'seoPagesGetPostWhere', 10, 2);
add_filter('posts_orderby', 'seoPagesOrderby', 10, 2);
add_filter('posts_join_paged', 'seoPageJoinPages', 10, 2);

/**
 * Putting sticky posts in seo-page in front of all posts, we do it by using new
 * Instapage WP filter called InstapageWpFilters::V7_LISTING_WP_QUERY
 */
add_filter(
    InstapageWpFilters::V7_LISTING_WP_QUERY,
    function ($queryArgs) {
        if (!in_array('seo-page', $queryArgs['post_type'])) {
            return $queryArgs;
        }

        $queryArgs['meta_query']['sticky'] = [
            'key' => 'sticky',
            'compare' => 'EXISTS'
        ];
        $queryArgs['orderby']['sticky'] = 'DESC';
        return $queryArgs;
    }
);

function seoPagesGetPostWhere($where, $query)
{
    global $wpdb;

    if (in_array('seo-page', (array) $query->get('post_type'))) {
        // custom attribute, I allow using it only in seo-page post type and when it is filled
        if ($postNameNotLike = $query->get('post_name_not_like')) {
            $where .= ' AND ' . $wpdb->posts . '.post_name NOT LIKE \'%' . $wpdb->esc_like($postNameNotLike) . '%\'';
        }

        // check if it is query for posts with pagination, if no do nothing,
        // for the good of us all
        if ($query->get('custom_pagination') === true) {
            $where .= ' AND ' . $wpdb->postmeta . '.meta_key = \'sticky\'';
        }
    }

    return $where;
}

function seoPageJoinPages($joinPagedStatement, $query)
{
    global $wpdb;

    // check if it is query for posts with pagination, if no do nothing,
    // for the good of us all
    if ($query->get('custom_pagination') !== true) {
        return $joinPagedStatement;
    }

    if ($query->get('post_type') === 'seo-page') {
        $joinPagedStatement .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id';
    }

    return $joinPagedStatement;
}

function seoPagesOrderby($orderbyStatement, $query)
{
    global $wpdb;

    // check if it is query for posts with pagination, if no do nothing,
    // for the good of us all
    if ($query->get('custom_pagination') !== true) {
        return $orderbyStatement;
    }

    if ($query->get('post_type') === 'seo-page') {
        $orderbyStatement = $wpdb->postmeta . '.meta_value DESC, ' .
                            $wpdb->posts . '.menu_order ASC';
    }

    return $orderbyStatement;
}

add_filter('wpseo_opengraph_image', 'customOpenGraphImageForSeoGuidesIntro');

define('CHAPTER_SLUG', '-chapter-');

function socialImage($image)
{
    $isSeoPage = isChapterListing();

    if ($isSeoPage) {
        $socialShareImageUrl = getSeoPageVariables();

        if ($socialShareImageUrl['social_share_image']) {
            $image = $socialShareImageUrl['social_share_image'];
        }
    }

    return $image;
}

function instapageSeoPageSocialShareTitle($content)
{
    if ( ! isChapterListing()) {
        return $content;
    }

    $result = getTaxonomyCustomField(['name' => null], 'seo_section');

    return isset($result['name']) ? $result['name'] : $content;
}

function getChapterNr($post = null)
{
    if ($post === null) {
        $post = get_post();
    }

    if ($post->post_type !== 'seo-page') {
        return false;
    }

    $chapterPattern = '/' . CHAPTER_SLUG . '([0-9]+)/';
    $matches        = [];
    preg_match($chapterPattern, $post->post_name, $matches);
    $chapterNr = getVar($matches[1], 0);

    return $chapterNr;
}

/**
 * Function for calculating max chapter number in seo-page posts.
 *
 * @return int $maxChapterNumber Returns max chapter number in posts
 */
function getSeoPageChaptersMaxCount()
{
    global $wpdb;
    $matches           = [];
    $maxChapterNumber  = 0;
    $chapterPostsNames = $wpdb->get_col("SELECT post_name FROM wp_posts WHERE post_type = 'seo-page' AND post_name LIKE '%" . CHAPTER_SLUG . "%'");

    foreach ($chapterPostsNames as $chapterPostName) {
        $pattern = '/' . CHAPTER_SLUG . '([\d]*?)$/';
        // go to next post name if match wasn't successull
        if (preg_match($pattern, $chapterPostName, $matches) !== 1) {
            continue;
        }

        $chapterNumber = intval($matches[1]);
        if ($chapterNumber > $maxChapterNumber) {
            $maxChapterNumber = $chapterNumber;
        }

    }

    return $maxChapterNumber;
}

function getSeoPageChapters($post)
{
    global $wpdb;

    $basePostName = preg_replace('/' . CHAPTER_SLUG . '[\d]*?$/', '', $post->post_name);
    $chaptersSlug = $basePostName . CHAPTER_SLUG . '%';
    $chaptersHtml = '';
    $chapterNr    = '';
    $searchQuery  = $wpdb->prepare("SELECT ID, post_excerpt FROM wp_posts WHERE post_type = 'seo-page' AND post_name LIKE '%s'",
        $chaptersSlug);
    $results      = $wpdb->get_results($searchQuery);
    $chaptersIds  = [];

    foreach ($results as $obj) {
        $chaptersIds[] = isset($obj->ID) ? $obj->ID : null;
    }

    if (empty($chaptersIds)) {
        return null;
    }

    $chapters = get_posts(
        [
            'posts_per_page' => -1,
            'post_type'      => 'seo-page',
            'post__in'       => $chaptersIds,
            'orderby'        => 'post_name',
            'post_status'    => 'any',
            'order'          => 'ASC'
        ]
    );

    usort($chapters, "compareChapterNumbers");

    return $chapters;
}


function compareChapterNumbers($chapter1, $chapter2)
{
    $chapterNr1 = getChapterNr($chapter1);
    $chapterNr2 = getChapterNr($chapter2);

    if ($chapterNr1 === $chapterNr2) {
        return 0;
    }

    return ($chapterNr1 < $chapterNr2) ? -1 : 1;
}

function getSeoPageChaptersHtml($post)
{

    if ($post->post_type !== 'seo-page') {
        return false;
    }

    $chapters = getSeoPageChapters($post);

    if ($chapters === null) {
        return '';
    }

    $contentPattern = '/<!--more-->(.*?)$/s';
    $chapterPattern = '/' . CHAPTER_SLUG . '([0-9]+)/';
    $matches        = [];

    foreach ($chapters as $chapter) {
        preg_match($chapterPattern, $chapter->post_name, $matches);
        $chapterNr = getVar($matches[1], '');
        $permalink = get_permalink($chapter);

        $chaptersHtml .= sprintf(
            '<div class="panel panel-floating panel-tile" data-link="%1$s">' .
            '<a href="%1$s" class="panel-number">%2$s</a>' .
            '<div class="panel-block">' .
            '<h3><a class="link-chameleon" href="%1$s">%3$s</a></h3>',
            $permalink,
            $chapterNr,
            $chapter->post_title
        );
        $excerpt      = trim(getVar($chapter->post_excerpt, ''));

        if ($excerpt === '') {
            $excerpt = preg_replace($contentPattern, '', $chapter->post_content);
        }

        $chaptersHtml .= sprintf(
            '<p>%1$s</p>' .
            '<a class="panel-link link-cta link-cta-big" href="%2$s">%3$s</a>' .
            '</div>' .
            '</div>',
            $excerpt,
            $permalink,
            __('Read Chapter')
        );
    }

    $chaptersHtml = sprintf(
        '<header class="division-header">' .
        '<h2>%1$s</h2>' .
        '</header>' .
        '<div class="content">%2$s</div>',
        __('Choose a Chapter'),
        $chaptersHtml
    );

    return $chaptersHtml;
}

function getSeoPageChaptersFooterHtml()
{
    global $post;

    if ($post->post_type !== 'seo-page') {
        return '';
    }

    $chapters = getSeoPageChapters($post);

    if ($chapters === null) {
        echo 'null';

        return '';
    }

    $contentPattern = '/<!--more-->(.*?)$/s';
    $chapterPattern = '/' . CHAPTER_SLUG . '([0-9]+)/';
    $matches        = [];

    $segmentHtml     = '';
    $chaptersLength  = count($chapters);
    $linkClass       = '';
    $activeChapterNr = getChapterNr($post);

    for ($i = 0; $i < $chaptersLength; $i++) {
        $chapter     = $chapters[$i];
        $chapterHtml = '';
        $chapterNr   = getChapterNr($chapter);
        $linkClass   = ($i + 1 === intval($activeChapterNr)) ? ' active ' : '';
        $permalink   = get_permalink($chapter);
        $chapterHtml .= '<a class="panel panel-floating panel-tile panel-small" href="' . $permalink . '">';
        $chapterHtml .= '<span class="panel-number">' . $chapterNr . '</span>';
        $chapterHtml .= '<div class="panel-block">' . $chapter->post_title . '</div>';
        $chapterHtml .= '</a>';
        $segmentHtml .= $chapterHtml;
    }

    $chaptersHtml .= '<header class="division-header">';
    $chaptersHtml .= '<h2>' . __('Choose a Chapter') . '</h2>';
    $chaptersHtml .= '</header>';
    $chaptersHtml .= '<div class="two-columns-half">' . $segmentHtml . '</div>';

    return $chaptersHtml;
}

function filterSeoPagesLink($url, $post, $leavename)
{

    if ($post->post_type === 'seo-page') {
        $url = str_replace(['/seo-page/', '/guides/'], '/', $url);
    }

    return $url;
}

function registerSeoPagesTaxonomy()
{

    $labels = [
        'name'              => __('SEO Sections'),
        'singular_name'     => __('SEO Section'),
        'search_items'      => __('Search SEO Sections'),
        'all_items'         => __('All SEO sections'),
        'parent_item'       => __('Parent section'),
        'parent_item_colon' => __('Parent section:'),
        'edit_item'         => __('Edit SEO Section'),
        'update_item'       => __('Update SEO Section'),
        'add_new_item'      => __('Add New SEO Section'),
        'new_item_name'     => __('New SEO Section name'),
        'menu_name'         => __('SEO Section')
    ];

    $args = [
        'label'     => __('SEO Sections'),
        'labels'    => $labels,
        'public'    => true,
        'query_var' => false,
        'rewrite'   => false
    ];

    register_taxonomy('seo_section', ['seo-page'], $args);
}

function registerSeoPagePosttype()
{
    $labels = [
        'name'          => __('SEO Pages'),
        'singular_name' => __('SEO Page')
    ];

    $supports = [
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt'
    ];

    $rewrite = [
        'with_front' => false,
        'feeds'      => false,
        'pages'      => true,
        'slug'       => 'guides'
    ];

    $args = [
        'labels'              => $labels,
        'taxonomies'          => ['seo_section'],
        'supports'            => $supports,
        'rewrite'             => $rewrite,
        'exclude_from_search' => true,
        'hierarchical'        => true,
        'public'              => true,
        'has_archive'         => true,
        'capability_type'     => ['seo_page', 'seo_pages'],
        'capabilities'        => [
            'read_post'           => 'read_seo_page',
            'publish_posts'       => 'publish_seo_pages',
            'edit_posts'          => 'edit_seo_pages',
            'edit_others_posts'   => 'edit_others_seo_pages',
            'delete_posts'        => 'delete_seo_pages',
            'delete_others_posts' => 'delete_others_seo_pages',
            'read_private_posts'  => 'read_private_seo_pages',
            'edit_post'           => 'edit_seo_page',
            'delete_post'         => 'delete_seo_page',
        ],
        'map_meta_cap'        => true
    ];

    register_post_type('seo-page', $args);
}

function isSeoPage()
{
    $post = get_post();

    if ( ! $post || $post->post_type !== 'seo-page') {
        return false;
    }

    return true;
}

function getSeoPageNeighbourUrl($neighbour = 'prev', &$neighbourPost = null, &$chapterNr = null)
{
    $post = get_post();

    if ( ! $post || $post->post_type !== 'seo-page') {
        return null;
    }

    $coreSlug    = '';
    $chapterSlug = CHAPTER_SLUG;
    $chapterNr   = 0;
    $matches     = [];
    $pattern     = '/(.*?)(' . CHAPTER_SLUG . ')([0-9]+)/';

    if (preg_match($pattern, $post->post_name, $matches)) {
        $coreSlug  = isset($matches[1]) ? $matches[1] : '';
        $chapterNr = isset($matches[3]) ? intval($matches[3]) : 0;
    } else {
        $coreSlug = $post->post_name;
    }

    $args          = [];
    $neighbourSlug = '';

    if ($neighbour === 'prev') {
        if ($chapterNr === 0) {
            return null;
        } else {
            if ($chapterNr >= 2) {
                $neighbourSlug = $coreSlug . $chapterSlug . ($chapterNr - 1);
                $chapterNr     = $chapterNr - 1;
            } else {
                $neighbourSlug = $coreSlug;
                $chapterNr     = 0;
            }
        }
    }

    if ($neighbour === 'next') {
        $neighbourSlug = $coreSlug . $chapterSlug . ($chapterNr + 1);
        $chapterNr     = $chapterNr + 1;
    }

    if ($neighbour === 'all') {
        $neighbourSlug = $coreSlug;
        $chapterNr     = 0;
    }

    $args = [
        'name'        => $neighbourSlug,
        'post_type'   => 'seo-page',
        'post_status' => 'publish'
    ];

    $posts = get_posts($args);

    if (is_array($posts) && count($posts) > 0) {
        $neighbourPost = array_pop($posts);

        return get_permalink($neighbourPost);
    } else {
        return null;
    }
}

function setCustomSeoPagesColumns($columns)
{

    $columns['seo_section'] = __('SEO Section');
    $columns['chapterNr']   = __('Chapter #');

    return $columns;
}

function customSeoPageColumn($column, $postId)
{

    switch ($column) {

        case 'seo_section':
            $args = ['name' => null];
            $data = getTaxonomyCustomField($args, 'seo_section', $postId);
            echo getVar($data['name'], __('N/A'));
            break;

        case 'chapterNr' :
            $post      = get_post($postId);
            $chapterNr = getChapterNr($post);
            echo $chapterNr ? $chapterNr : __('Intro');
            break;
    }
}

function seoPagesEditorStyles()
{

    global $post;
    $customPostType = 'seo-page';

    if (stristr($_SERVER['REQUEST_URI'],
            'post-new.php') !== false && (isset($_GET['post_type']) === true && $customPostType === $_GET['post_type'])) {
        add_editor_style(get_template_directory_uri() . '/assets/css/editor-style-' . $customPostType . '.css');
    }

    if (stristr($_SERVER['REQUEST_URI'],
            'post.php') !== false && is_object($post) && $customPostType === get_post_type($post->ID)) {
        add_editor_style(get_template_directory_uri() . '/assets/css/editor-style-' . $customPostType . '.css');
    }
}

function getSeoPageVariables()
{
    $classArr = ['seo-page'];
    $result   = [];

    $fields = [
        'seo_section_binded_file' => 'url',
        'seo_section_html_header' => null,
        'seo_section_class'       => null,
        'social_share_image'      => null
    ];

    $custom_fields                = getTaxonomyCustomField($fields, 'seo_section');
    $result['pdf_link']           = isset($custom_fields['seo_section_binded_file']) ? $custom_fields['seo_section_binded_file'] : null;
    $result['html_header_text']   = isset($custom_fields['seo_section_html_header']) ? $custom_fields['seo_section_html_header'] : __('What is a landing page?');
    $result['seo_section_class']  = isset($custom_fields['seo_section_class']) ? $custom_fields['seo_section_class'] : '';
    $result['chapter_nr']         = getChapterNr();
    $result['social_share_image'] = isset($custom_fields['social_share_image']['url']) ? $custom_fields['social_share_image']['url'] : '';

    if ($result['seo_section_class'] !== '') {
        $classArr[] = $result['seo_section_class'];
    }

    if (isChapterListing()) {
        $classArr[] = 'front';
    } elseif ($result['chapter_nr']) {
        $classArr[] = 'chapter-' . $result['chapter_nr'];
    }

    $result['class_arr'] = $classArr;

    return $result;
}

/**
 * Generete select for filtering posts by chapters
 *
 * @return string $selectHtml Html with select for filtering posts by chapters
 */
function generateSeoPageChapterSelect()
{
    $maxChapterNumber = getSeoPageChaptersMaxCount();
    $choosedChapter   = filter_input(INPUT_GET, 'seo-page-chapter-filter', FILTER_VALIDATE_INT);

    $selectHtml = '<select name="seo-page-chapter-filter">' .
                  '<option value="">' . __('All Chapters') . '</option>';

    for ($chapterNumber = 0; $chapterNumber <= $maxChapterNumber; $chapterNumber++) {
        $selected   = (is_int($choosedChapter) && $chapterNumber === $choosedChapter) ? ' selected="selected" ' : '';
        $optionName = $chapterNumber > 0 ? __('Chapter ') . $chapterNumber : __('Intro');

        $selectHtml .= '<option value="' . $chapterNumber . '"' . $selected . '>' .
                       $optionName .
                       '</option>';
    }

    $selectHtml .= '</select>';

    return $selectHtml;
}

/**
 * Generate select for filtering posts by category
 *
 * @uses \get_terms
 *
 * @return string $filterHtml String containing select for filtering posts by category
 */
function generateSeoPageCategorySelect()
{
    $args         = ['name' => 'seo_section'];
    $sections     = get_terms($args, 'objects');
    $currentValue = filter_input(INPUT_GET, 'seo-page-category', FILTER_VALIDATE_INT);
    $filterHtml   = '<select name="seo-page-category">' .
                    '<option value="">' . __('All SEO Sections') . '</option>';

    foreach ($sections as $section) {
        $selected   = ((int)$section->term_id === (int)$currentValue) ? ' selected="selected" ' : '';
        $filterHtml .= '<option value="' . $section->term_id . '"' . $selected . '>' . $section->name . '</option>';
    }

    $filterHtml .= '</select>';

    return $filterHtml;
}

/**
 * Generete custom filtering selects for seo-page posts listing in wp-admin
 *
 * @param string $PostType The post type slug.
 */
function seoPagesPostFilterRestrictPosts($PostType)
{
    if ($PostType === 'seo-page') {
        echo generateSeoPageCategorySelect();
        echo generateSeoPageChapterSelect();
    }
}

/**
 * Check if current process page is seo-page posts listing in wp-admin. If yes return true.
 *
 * @global type  $pagenow
 *
 * @param object $query The WP_Query instance (passed by r
 *
 * @return bool
 */
function isSeoPageAdminListing($query)
{
    global $pagenow;

    return $query->query['post_type'] === 'seo-page'
           && is_admin()
           && $pagenow === 'edit.php';
}

/**
 * Adjust $where clause for filtering by chapters in seo-page listing in wp-admin
 *
 * @uses \is_admin()
 *
 * @param string $where The WHERE clause of the query
 * @param object $query The WP_Query instance (passed by reference)
 *
 * @return string Where clause after adjustment
 */
function seoPagesChaptersFilter($where, $query)
{
    if ( ! isSeoPageAdminListing($query)) {
        return $where;
    }

    $choosedChapter = filter_input(INPUT_GET, 'seo-page-chapter-filter', FILTER_VALIDATE_INT);
    if ( ! is_int($choosedChapter)) {
        return $where;
    }

    if ($choosedChapter === 0) {
        $where .= " AND post_name NOT LIKE '%" . CHAPTER_SLUG . "%'";
    } else {
        $where .= " AND post_name LIKE '%" . CHAPTER_SLUG . $choosedChapter . "'";
    }

    return $where;
}

function seoPagesPostFilter($query)
{
    if ( ! isSeoPageAdminListing($query)) {
        return $query;
    }

    $searchedSeoSection = isset($_GET['seo-page-category']) ? $_GET['seo-page-category'] : '';

    if ($searchedSeoSection === '') {
        return $query;
    }

    $taxquery = [
        [
            'taxonomy' => 'seo_section',
            'field'    => 'id',
            'terms'    => [$searchedSeoSection],
            'operator' => 'IN'
        ]
    ];

    $query->set('tax_query', $taxquery);

    return $query;
}

function getSeoPageHeaderBackground()
{
    global $post;
    $backgroundArray = get_field('header_image', $post->ID);
    $backgroundUrl   = isset($backgroundArray['url']) ? $backgroundArray['url'] : '';

    if ( ! $backgroundUrl) {
        $terms      = wp_get_post_terms($post->ID, 'seo_section');
        $seoSection = array_pop($terms);

        if ( ! isset($seoSection->term_id)) {
            return '';
        }

        $backgroundArray = get_field('default_header_image', 'seo_section_' . $seoSection->term_id);
        $backgroundUrl   = isset($backgroundArray['url']) ? $backgroundArray['url'] : '';
    }

    return $backgroundUrl;
}

function getSeoSectionHeader()
{
    global $post;
    $terms      = wp_get_post_terms($post->ID, 'seo_section');
    $seoSection = array_pop($terms);
    $sectionId  = isset($seoSection->term_id) ? $seoSection->term_id : null;

    if ( ! $sectionId) {
        return '';
    }

    $header = get_field('seo_section_html_header', 'seo_section_' . $sectionId);

    if ( ! $header) {
        return isset($seoSection->name) ? $seoSection->name : '';
    }

    return $header;
}

/**
 * Modifing open graph image (og:image) for intro pages of the SEO Guides
 *
 * Use 'wpseo_opengraph_image' Yoast filter for running this function.
 * This function return default og:image if opengraph-image is not set for post.
 * We skip outputting featured, content image as an og:image
 *
 * @param string $openGraphImage URL to og:image
 *
 * @return string
 */
function customOpenGraphImageForSeoGuidesIntro($openGraphImage)
{
    // check is it intro page of SEO Guide, if no do nothing
    if (getChapterNr() !== 0) {
        return $openGraphImage;
    }

    // return opengraph image for post if it is set
    global $post;
    $ogImg = WPSEO_Meta::get_value('opengraph-image', $post->ID);
    if ( ! empty($ogImg)) {
        return $ogImg;
    }

    // get options from Yoast addon
    $options = WPSEO_Options::get_option('wpseo_social');

    // return default image
    return $options['og_default_image'];
}
