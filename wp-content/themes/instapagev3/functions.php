<?php
define( 'URL_INSTAPAGE', '//app.instapage.com' );
define( 'URL_INSTAPAGE_SIGNUP', URL_INSTAPAGE . '/auth/signup' );
define( 'URL_INSTAPAGE_LOGIN', URL_INSTAPAGE . '/auth/login' );
define( 'URL_INSTAPAGE_CONTACT', 'https://instapage.com/enterprise-demo-request' );
define( 'URL_INSTAPAGE_HELP', 'https://help.instapage.com/hc/en-us' );

/**
 * Autoloades is registered in index.php to perform pre WP init actions.
 * If a request doesn't go through index.php, register the autoloader here.
 */

if (empty(array_keys(spl_autoload_functions(), 'instapageAutoloader'))) {
  require_once(get_template_directory() . '/pre-wp-actions/autoloader.php');
}

add_theme_support( 'post-thumbnails' );
add_image_size( 'listing-size', 704, 0, false );
add_image_size( 'listing-size-retina', 1408, 0, false );
add_image_size( 'v5-single-size', 770, 384, true );
add_image_size( 'v5-single-size-retina', 1540, 768, true );
add_image_size( 'v7-listing-size', 570, 285, true );
add_image_size( 'v7-listing-size-retina', 1140, 570, true );
add_image_size( 'v5-listing-size', 570, 310, true );
add_image_size( 'v5-listing-size-retina', 1140, 620, true );
add_image_size( 'v5-resources-size', 270, 147, true );
add_image_size( 'v5-resources-size-retina', 540, 294, true );
add_action( 'wp_enqueue_scripts', 'instapageScripts', 1 );
add_filter( 'excerpt_more', 'excerptMoreLink' );
add_filter( 'parse_request', 'instapageParseRequest' , 1, 1 );
add_filter('the_excerpt_rss', 'featuredImageInRss');
add_filter('the_content_feed', 'featuredImageInRss');
add_filter('the_content', 'lazyloadImageReplace');
add_filter( 'style_loader_src', 'vcRemoveWpVerCssJs', 9999 );
add_filter( 'script_loader_src', 'vcRemoveWpVerCssJs', 9999 );
remove_filter( 'template_redirect', 'redirect_canonical' );
add_filter('wp_embed_handler_youtube', 'responsiveVideoEmbed', 10, 4);
add_filter('wp_embed_handler_wistia', 'responsiveVideoEmbed', 10, 4);
add_action( 'init', 'register_my_menus' );
add_action( 'init', 'instapageSeoRules' );
add_action( 'init', 'disableTags' );
add_action( 'init', 'addInstapagePostStatuses' );
add_action( 'template_redirect', 'disableTagsUrls' );
add_action( 'init', 'changeAuthorPermalinks' );
add_filter( 'wp_title', 'instapageSeoTitle', 1, 2 );
add_filter( 'wpseo_metadesc', 'instapageSeoDescription', 1 );
add_filter( 'author_link', 'instapageSeoAuthorLink', 1, 3 );
add_action( 'wp', 'instapageRequestFilter', 1, 1 );
add_action( 'login_enqueue_scripts', 'instapageAdminCss' );
add_action( 'init', 'addVideoProviders' );
remove_filter( 'the_content', 'show_share_buttons' );
remove_action( 'wp_head', 'get_ssba_style' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_shortcode( 'ssba', 'ssba_buttons' );
remove_shortcode( 'ssba_hide', 'ssba_hide' );
add_filter( 'wpseo_json_ld_output', 'instapageDisableSearchJsonLd' );
add_action( 'publish_post', 'purgeFacebookCache', 20, 2 );
add_action( 'publish_seo-page', 'purgeFacebookCache', 20, 2 );
add_filter( 'get_the_excerpt', 'instapageExcerptFilter', 10 );
add_filter( 'post_thumbnail_html', 'instapageThumbnailFilter', 100, 1 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
add_action( 'wp_head', 'instapageShortlink', 10, 0 );
add_action( 'wp', 'instapageAttachmentRedirect' );
add_filter( 'wpseo_canonical', 'instapageWPSEOCanonical' );
add_filter( 'wpseo_opengraph_url', 'instapageWPSEOOpengraph' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;
add_action( 'wp_head', 'enqueueInstapageStyles' );
add_action( 'admin_footer-post.php', 'appendInstapagePostStatuses' );
add_action( 'admin_enqueue_scripts', 'instapageCustomAdminCss' );
add_action( 'add_attachment', 'instapageSaveOriginalAttachment', 1, 1 );
add_filter( 'upload_mimes', 'ccMimeTypes' );
add_action( 'script_loader_tag', 'instapageAddScriptVersion', 10, 1 );
add_action( 'style_loader_tag', 'instapageAddScriptVersion', 10, 1 );
add_action('wp_print_styles', 'dequeueClickToTweetCss', 100);
add_action('admin_print_scripts', 'addCustomAdminJs');
add_filter('wp_dropdown_users_args', 'filterAuthorEditDropdown', 10, 1);
add_action( 'user_register', 'instapageUserRegister', 10, 1 );
add_filter('nocache_headers', 'modifyNoCacheHeaders', 9999, 1);
add_action('after_setup_theme', 'removeAdminBar');
add_filter('embed_oembed_html', 'filterEmbededContent', 99, 1);
add_filter('get_the_post_video_filter', 'filterEmbededContent', 99, 1);
add_action('validate_password_reset', 'instapageValidatePasswordReset', 10, 2);
add_filter('retrieve_password_message', 'instapagePasswordResetMessage', 9999, 4);
add_action('pre_get_posts', 'instapageSearchQuery');
add_action('init', 'instapageInitNonce', 11);
add_action('login_form', 'instapageLoginFormNonce');
add_filter('wp_authenticate_user', 'instapageLoginFormNonceValidation', 10, 3);
add_action('wp_update_nav_menu', 'refreshV5Menus', 10, 2);
remove_action('wp_head', array('Tasty_Pins\Frontend', 'action_wp_head_print_pinit_js'));
add_action('update_option_permalink_structure', ['\Instapage\Models\SiteMap\SiteMapCache', 'deleteHtmlSiteMapFromCache']);
add_action('update_option', 'handleUpdateOptions', 10, 3);
add_action('save_post', ['\Instapage\Models\SiteMap\SiteMapCache', 'deleteHtmlSiteMapFromCache']);
add_filter('pre_get_posts', 'excludePostsFromFeed');
add_action('wp_head', 'leftRightCustomStyling', 100);
add_filter('wp_insert_attachment_data', 'addSuffixForAtachments', 10, 2);
add_action('wp_footer', function() {
  renderCookiesConsentMessage();
});

add_action('send_headers', function () {
  (new \Instapage\Classes\ResponseHeaderGenerator\ResponseHeaderGenerator())->setHeaders();
});

// Sometimes we need to set headers based on whole WP environment, so we use additional method
add_action('wp', function () {
  (new \Instapage\Classes\ResponseHeaderGenerator\ResponseHeaderGenerator())
    ->setHeadersWithFullWpEnvironment();
});

remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

/**
 * Render cookies constent message html
 *
 * @return void;
 */
function renderCookiesConsentMessage() {
  \Instapage\Classes\Component::render('v51/cookies');
}

/**
 * Method for generating css for given img box in left/right section
 *
 * @param array $adjustments      ACF array with adjustment for current left/right section
 * @param integer $ordinalNumber  Ordinal number of current left/right section
 * @return string String containg css for img-box
 */
function cssImgBox($adjustments, $ordinalNumber) {
  $css = '';
  $height = isset($adjustments['image_height'])
          ? intval($adjustments['image_height'])
          : 0;

  // we assume that when height is zero do not print anything
  // also zero is default value
  if ($height > 0) {
    $css = '.left-right-img-box.left-right-img-box-' . $ordinalNumber . ' {' .
           'height: ' . $height . 'px' .
           '} ';
  }

  return $css;
}

/**
 * Method for generating css for given left-right-text element in left/right section
 *
 * @param array $adjustments      ACF array with adjustment for current left/right section
 * @param integer $ordinalNumber  Ordinal number of current left/right section
 * @return string String containg css for left-right-text element
 */
function cssTextSpacing($adjustments, $ordinalNumber) {
  $css = '';
  $topSpacing = isset($adjustments['top_spacing'])
              ? intval($adjustments['top_spacing'])
              : 0;

  // $topSpacing default value is zero,
  // so for zero do not print any css
  if ($topSpacing !== 0) {
    $css = '.left-right-text-' . $ordinalNumber . ' {' .
           'margin-top: ' . $topSpacing . 'px' .
           '} ';
  }

  return $css;
}

/**
 * Generate custom css for left/right to inject to <head tag.
 *
 * @return void
 */
function leftRightCustomStyling() {
  $leftRightCss = '';
  $ordinalNumber = 0;

  if (have_rows('leftright')) {
    while (have_rows('leftright')) {
      the_row();
      $ordinalNumber++;
      // group of custom adjustments, like custom margins, custom heights etc.
      $adjustments = get_sub_field('adjustments');

      // generate css for given rows if needed
      $leftRightCss .= cssTextSpacing($adjustments, $ordinalNumber);
      $leftRightCss .= cssImgBox($adjustments, $ordinalNumber);
    }
  }

  // if there is a custom css for text in left/right, print it in head tag
  if (strlen($leftRightCss) > 0) {
    echo '<style type="text/css">' .
         '@media (min-width: 970px) {' . $leftRightCss .
         '}' .
         '</style>';
  }
}

/**
 * Filters attachment post data before it is updated in or added to the database
 *
 * Filtering purpose is to adjust slug of attachemnt on adding new attachement.
 *
 * @param array $data    An array of sanitized attachment post data.
 * @param array $postarr An array of unsanitized attachment post data.
 *
 * @return array $data Return changed $data array for attachment
 */
function addSuffixForAtachments($data, $postarr) {
  // If the 'ID' is set in the $postarr parameter, it means that wordpress are
  // updating and attempt to update the attachment. Zero means that this is adding attempt
  if ($postarr['ID'] !== 0) {
    return $data;
  }

  $suffix = '-attachment';
  $suffixLength = strlen($suffix);

  // check if post_name is without suffix, it is very rare but can occure that
  // file name has at the end -attachment suffix
  if (substr($data['post_name'], -$suffixLength) !== $suffix) {
    // add suffix for attachment, to avoid slug colisions among attachements and regular posts
    $data['post_name'] = $data['post_name'] . $suffix;
  }

  return $data;
}

/**
 * Exclude posts from feed based on custom field settings.
 *
 * If custom field removeFromFeed is set to true, given post will be not listed in the feed.
 *
 * @param WP_Query $query The $query object is passed to the function by reference.
 *
 * @return void
 */
function excludePostsFromFeed($query) {
  if (!$query->is_admin && $query->is_feed) {
    $query->set('meta_query', [
      'relation' => 'OR',
      [
          'key' => 'removeFromFeed',
          'compare' => 'NOT EXISTS',
          'value'   => '0' // there has to be something, wp bug #23268
      ],
      [
          'key' => 'removeFromFeed',
          'compare' => '!=',
          'value' => '1'
      ]
    ]);
  }
}

function handleUpdateOptions($option, $old_value, $new_value) {
  if ($option === 'rewrite_rules') {
    \Instapage\Models\SiteMap\SiteMapCache::deleteHtmlSiteMapFromCache();
  }
}

function instapageValidatePasswordReset($errors, $user) {
  $rules = [
    new \Instapage\Classes\Validator\ValidatorRuleLength('>=', 12),
    new \Instapage\Classes\Validator\ValidatorRuleUppercase('>=', 2),
    new \Instapage\Classes\Validator\ValidatorRuleLowercase('>=', 2),
    new \Instapage\Classes\Validator\ValidatorRuleDigit('>=', 1),
    new \Instapage\Classes\Validator\ValidatorRuleSpecial('>=', 1)
  ];

  if (isset($_POST['pass1'])) {
    $messages = [];
    foreach ($rules as $rule) {
      if (!$rule->isValid($_POST['pass1'])) {
        $messages[] = $rule->getMessage();
      }
    }

    if (!empty($messages)) {
      $errors->add('password-strength', __('Your password should:'));
      foreach ($messages as $message) {
        $errors->add('password-strength', $message);
      }
    }
  }

  return $errors;
}

if (function_exists('acf_add_options_page')) {
    $currentUser = wp_get_current_user();

    if ($currentUser->has_cap('manage_options')) {
        acf_add_options_page([
            'page_title' => __('Custom site config'),
            'menu_title' => __('Custom site config'),
            'menu_slug' => 'custom-site-config',
            'capability' => 'edit_posts'
        ]);

        acf_add_options_sub_page([
            'page_title' => __('Convert Pro - stage popups'),
            'menu_title' => __('Convert Pro - stage popups'),
            'parent_slug' => __('custom-site-config')
        ]);

        acf_add_options_sub_page([
          'page_title' => __('Default component values'),
          'menu_title' => __('Default component values'),
          'parent_slug' => __('custom-site-config')
        ]);

        acf_add_options_sub_page([
            'page_title' => __('Messagebar editor'),
            'menu_title' => __('Messagebar editor'),
            'parent_slug' => __('custom-site-config')
        ]);

        acf_add_options_sub_page([
            'page_title' => __('Cache settings - useful for live pushes'),
            'menu_title' => __('Cache settings'),
            'parent_slug' => __('custom-site-config')
            ]);
    }
}

if( class_exists( 'WPSEO_Frontend' ) )
{
  remove_action( 'wpseo_head', array( WPSEO_Frontend::get_instance(), 'robots' ) );
  add_action( 'wpseo_head', 'instapageWPSEORobots', 10 );
}

if( class_exists( 'FVP_Frontend' ) )
{
  add_action( 'wp_print_scripts', 'instapageFVPDequeueScripts', 100 );
  add_action( 'wp_print_styles', 'instapageFVPDequeueStyles', 100 );
}

if( class_exists( 'WPSEO_OpenGraph' ) )
{
  add_filter( 'wpseo_opengraph_title', 'instapageSocialTitle', 10, 1 );
  add_filter( 'wpseo_opengraph_desc', 'instapageOpengraphDescription', 10, 1 );
}

if( class_exists( 'WPSEO_Twitter' ) )
{
  add_filter( 'wpseo_twitter_title', 'instapageSocialTitle', 10, 1 );
}

// function customizations for plugins
include(get_template_directory() . '/functions/plugins-customizations/defender/functions-defender-customization.php');
include(get_template_directory() . '/functions/plugins-customizations/menu-image/functions-menu-image.php');
include(get_template_directory() . '/functions/plugins-customizations/wp-emoji/functions-wp-emoji-customization.php');
include(get_template_directory() . '/functions/plugins-customizations/wp-stateless/functions-wp-stateless.php');

include(get_template_directory() . '/shortcodes/instapage-shortcodes.php');
include(get_template_directory() . '/functions/functions-common.php');
include(get_template_directory() . '/functions/functions-seo-page.php');
include(get_template_directory() . '/functions/functions-features.php');
include(get_template_directory() . '/functions/functions-dictionary.php');
include(get_template_directory() . '/functions/functions-podcast.php');
include(get_template_directory() . '/functions/functions-customer-stories.php');
include(get_template_directory() . '/functions/functions-webinar.php');
include(get_template_directory() . '/functions/functions-video.php');
include(get_template_directory() . '/functions/functions-ebook.php');
include(get_template_directory() . '/functions/functions-integration.php');
include(get_template_directory() . '/functions/functions-product.php');
include(get_template_directory() . '/functions/functions-solution.php');
include(get_template_directory() . '/functions/functions-sticky.php');
include(get_template_directory() . '/functions/functions-convertpro.php');
include(get_template_directory() . '/functions/functions-seo-related.php');

add_action( 'init', 'v5checkRequiredPlugins' );
add_action( 'init', 'v5LoadAmpClasses' );
add_action( 'init', 'v5LoadCustomSitemapClasses' );
add_filter( 'archive_template', 'getCustomPostTypeTemplate' );
add_filter( 'page_template', 'getCustomPostTypeTemplate' );
add_filter( 'template_include', 'getCustomPostTypeTemplate' );

function v5LoadAmpClasses() {
  include(get_template_directory() . '/functions/functions-amp.php');
}

function v5LoadCustomSitemapClasses() {
  include(get_template_directory() . '/v5/classes/custom-sitemap/CustomSitemap.php');
  include(get_template_directory() . '/v5/classes/custom-sitemap/RootSitemap.php');

  include(get_template_directory() . '/functions/functions-amp-landing-page-templates.php');
  include(get_template_directory() . '/functions/functions-amp-marketing-dictionary.php');
  include(get_template_directory() . '/functions/functions-amp-post-sitemap.php');
  include(get_template_directory() . '/functions/functions-amp-seo-sitemap.php');
  include(get_template_directory() . '/functions/functions-amp-single-features-sitemap.php');
  include(get_template_directory() . '/functions/functions-amp-case-study.php');
  include(get_template_directory() . '/functions/functions-single-template-sitemap.php');
}

function getCustomPostTypeTemplate($archiveTemplate) {
  $customArchiveFile = get_template_directory() . '/v5/init.php';
  if (file_exists($customArchiveFile)) {
    return $customArchiveFile;
  }

  return $archiveTemplate;
}

/**
 * Add action for clearing stale nonces
 */
function instapageClearNonces() {
  \Instapage\Classes\SimpleNonce::clearNonces();
}
add_action('instapage_clear_nonces', 'instapageClearNonces');

/**
 * Register cron job to run every hour
 */
add_action('init', function() {
  if (!wp_next_scheduled('instapage_clear_nonces')) {
    wp_schedule_event(time(), 'hourly', 'instapage_clear_nonces');
  }
});

/**
 * Returns true if currently displayed page is category listing, author listing, archive or home
 * @return bool
 */
function isArchiveExtended($post = '') {
  global $wp_query;

  $post = (!empty($post)) ? $post : get_post();
  $isSearch = $wp_query->is_main_query() && $wp_query->is_search();
  return ((is_home() || is_archive($post)) || is_author() || is_category() || $isSearch);
}

/**
 * Returns name of given type/page handled by v5 engine.
 * @param  object|string $post (optional) Type/Post object OR string for other/legacy items
 * @return string
 */
function getV5Page($post = '') {
  $post = (!empty($post)) ? $post : get_post();
  $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

  // Special or custom items, for example: search
  if (isSearch()) {
    return 'search';
  }

  if (\Instapage\Classes\CustomSitemap\CustomSitemap::getInstance()->isSitemap($requestPath)) {
    return 'custom-sitemap';
  }

  if (is_404()) {
    return '404';
  }

  if (\Instapage\Classes\Templates\ClassTemplates::isSingleTemplatePatternMatched()) {
    return 'single-template-page';
  }

  if (is_string($post)) {
    return $post;
  }

  // Pages
  if ($post->post_type === 'page') {
    return $post->post_name;
  }
  return $post->post_type;
}

/**
 * V5 style pagination
 * @return array
 */
function getV5Pagination() {
  global $wp_query;

  $items = [];
  $items = paginate_links(
    [
      'base' => str_replace(99999999, '%#%', esc_url(get_pagenum_link(99999999))),
      'format' => '?paged=%#%',
      'current' => max(1, get_query_var('paged')),
      'total' => $wp_query->max_num_pages,
      'prev_text' => __('Prev.'),
      'next_text' => __('Next'),
      'mid_size' => 1,
      'end_size' => 0,
      'type' => 'array'
    ]
  );

  return $items;
}

/**
 * Returns value of ACF field
 * @param  string $name Name of ACF field
 * @param  string $defaultValue Default value to return in case ACF returns empty value
 * @param  int    $contextID (optional) ID of page from which ACF data should be pulled from
 * @return string
 */
function getAcfVar($name, $defaultValue = '', $contextID = null) {
  if ((!isset($name)) || (empty($name))) {
    return $defaultValue;
  }

  $value = (is_null($contextID)) ? get_field($name) : get_field($name, $contextID);
  return (!empty($value)) ? $value : $defaultValue;
}

/**
 * Returns values of multiple ACF fields.
 * Input arrays has to be non-empty and the same size - otherwise defaults will be returned
 * @param  array $names Names of ACF field
 * @param  array $defaultValues Default values to return in case ACF returns empty value
 * @param  int   $contextID (optional) ID of page from which ACF data should be pulled from
 * @uses   getAcfVar()
 * @return array
 */
function getAcfVars($names = [], $defaultValues = [], $contextID = null) {
  if ((empty($names)) || (!is_array($names)) || (empty($defaultValues)) || (!is_array($defaultValues)) || (count($names) !== count($defaultValues))) {
    return $defaultValues;
  }

  $items = [];
  for ($i = 0, $c = count($names); $i < $c; $i++) {
    $items[] = getAcfVar(
      $names[$i],
      $defaultValues[$i],
      $contextID
    );
  }

  return $items;
}

/**
 * Gets post featured image path for given size
 * @param  int $postID ID of post
 * @param  string $size Required image size
 * @return string Path to be used as image `src` atrribute
 * @see    getV5SrcSet(), getV5Dimensions()
 */
function getV5Src($postID, $size = 'v5-single-size') {
  $thumbnailID = get_post_thumbnail_id($postID);
  $image = wp_get_attachment_image_src($thumbnailID, $size);
  return $image[0];
}

/**
 * Gets dimensions of post featured image
 * @param  int $postID ID of post
 * @param  string $size Required image size, if it's not available - default will be used
 * @param  mixed $dimensions Required dimensions. Can be 'width', 'height' or 'both'. Default is 'both'
 * @param  string $size Required image size
 * @return string Path to be used as image `src` atrribute
 * @see    getV5Src(), getV5SrcSet()
 */
function getV5Dimensions($postID, $size = 'v5-single-size', $dimensions = 'both') {
  $thumbnailID = get_post_thumbnail_id($postID);
  $meta = wp_get_attachment_metadata($thumbnailID);

  $image = (isset($meta['sizes'][$size])) ? $meta['sizes'][$size] : $meta;

  $return = '';
  switch ($dimensions) {
    case 'width':
      $return = 'width="' . $image['width'] . '"';
      break;
    case 'height':
      $return = 'height="' . $image['height'] . '"';
      break;
    case 'both':
    default:
      $return = 'width="' . $image['width'] . '" height="' . $image['height'] . '"';
  }

  return $return;
}

/**
 * Gets post featured image paths for given sizes and returns as a string for `srcset` attribute.
 * In case when there's no retina image available (both images point to the same file) only regular one is returned
 * @param  int $postID ID of post
 * @param  string $regularSize Required image regular size
 * @param  string $retinaSize Required image retina size
 * @return string String to be used directly as image `srcset` atrribute
 * @see    getV5Src(), getV5Dimensions()
 */
function getV5SrcSet($postID, $regularSize = 'v5-single-size', $retinaSize = 'v5-single-size-retina') {
  $thumbnailID = get_post_thumbnail_id($postID);
  $image = wp_get_attachment_image_src($thumbnailID, $regularSize);
  $imageRetina = wp_get_attachment_image_src($thumbnailID, $retinaSize);
  return ((!empty($imageRetina)) && ($image[0] === $imageRetina[0])) ? $image[0] . ' 1x' : $image[0] . ' 1x, ' . $imageRetina[0] . ' 2x';
}

/**
 * Returns url to amp version of given url or empty if given page is not supported by amp
 * @param  string $url
 * @return string Url to AMP version or empty string
 */
function getV5AmpUrl() {
  global $amp;
  return $amp->getAmpUrl();
}

/**
 * Returns true if search query is not empty
 * @return bool
 */
function isSearch() {
  return ((trim(get_search_query()) != '') || (isset($_GET['s']) && !empty($_GET['s'])));
}

function v5checkRequiredPlugins() {
  $requiredPlugins = [
    'user-role-editor-pro/user-role-editor-pro.php',
    'advanced-custom-fields-pro/acf.php'
  ];
  $activePlugins = get_option('active_plugins');
  $missingPlugins = array_diff($requiredPlugins, $activePlugins);

  if ((!is_admin()) && (!isLoginPage()) && (!empty($missingPlugins))) {
    error_log(sprintf('Following plugins are missing: %s', implode(', ', $missingPlugins)));
    exit('Error occured. Please check logs for more information.');
  }
}

/**
 * Check whether current page is login or register
 * @return bool
 */
function isLoginPage() {
  return in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']);
}

function instapageCustomAdminCss()
{
  wp_enqueue_style( 'custom-admin-theme', get_template_directory_uri() . '/assets/css/instapage-admin.css' );
}

function instapageSocialTitle( $title )
{
  return wp_title( '', false );
}

function instapageOpengraphDescription( $description )
{
  if( class_exists( 'WPSEO_Frontend' ) )
  {
    return WPSEO_Frontend::get_instance()->metadesc( false );
  }
  else
  {
    return $description;
  }
}

function instapageFVPDequeueScripts()
{
  if( !is_single() || isSeoPage() )
  {
    wp_dequeue_script( 'fvp-frontend' );
    wp_dequeue_script( 'jquery.fitvids' );
    wp_dequeue_script( 'jquery.domwindow' );
  }
}

function instapageFVPDequeueStyles()
{
  if( !is_single() || isSeoPage() )
  {
    wp_dequeue_style( 'fvp-frontend' );
  }
}

function instapageAttachmentRedirect()
{
  if ( is_attachment() )
  {
    global $post;

    if( isset( $post->post_parent ) && is_numeric( $post->post_parent ) && ( $post->post_parent != 0 ) )
    {
      wp_redirect( get_permalink( $post->post_parent ), 301 );
      exit();
    }
    else
    {
      global $wp_query;
      $wp_query->set_404();
    }
  }
}

function instapageShortlink()
{

  global $post;

  if( !$post->post_type == 'page' && !isStatic() && !isSeoPage() )
  {
    wp_shortlink_wp_head();
  }
}

function instapageExcerptFilter( $excerpt )
{
  if( !is_feed() )
  {
    $readmore = apply_filters( 'excerpt_more', '' );

    if ( strpos( $excerpt, $readmore ) === false )
    {
      $excerpt = $excerpt . $readmore;
    }
  }

  return $excerpt;
}

function getPostThumbnailSrcSet( $post_id )
{
  $sizes = get_intermediate_image_sizes();
  $srcset = array();

  foreach( $sizes as $size )
  {
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size );
    $srcset[] = $thumb[ 0 ] . ' '. $thumb[ 1 ] . 'w';
  }

  return implode( ', ', $srcset );
}

function instapageThumbnailFilter( $html )
{
  if( is_feed() )
  {
    global $post;

    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'listing-size' );
    $patterns = array
    (
      '/<div.*?class=".*?featured-video-plus.*?".*?>.*?<\/div>/',
      '/<img.*?class=".*?fvp-onload.*?".*?\/>/'
    );

    $replace = array
    (
      '',
      '<img src="' . $thumb[ 0 ] . '" width="' . $thumb[ 1 ] . '" height="' . $thumb[ 2 ] . '" srcset="' . getPostThumbnailSrcSet( $post->ID ) . '" sizes="(min-width: 780px) 60vw, 90vw" alt="" />'
    );

    $html = preg_replace( $patterns, $replace, $html );
  }

  return $html;
}

function instapageSaveOriginalAttachment( $image_id )
{
  if ( wp_attachment_is_image( $image_id ) )
  {
    $image_path = get_attached_file( $image_id );
    $uploads_infix = 'wp-content/uploads';
    $original_file_infix = 'wp-content/uploads/orig';

    if( strpos( $image_path, $uploads_infix ) !== false )
    {
      $image_backup_path = str_replace( $uploads_infix, $original_file_infix, $image_path );
    }
    else
    {
      return false;
    }

    $pathinfo = pathinfo( $image_backup_path );

    if( !isset( $pathinfo[ 'dirname' ] ) )
    {
      return false;
    }

    if( !file_exists( $pathinfo[ 'dirname' ] ) )
    {
      mkdir( $pathinfo[ 'dirname' ], 0755, true );
    }

    return copy( $image_path, $image_backup_path );
  }
}

/**
 * Gracefully overrides the YOAST SEO plugin WPSEO_Frontend::robots() function. Removes unnecessary robots metatag.
 * @uses WPSEO_Frontend::get_instance()
 * @uses WPSEO_Frontend::robots()
 * @uses \Instapage\Classes\Templates\ClassTemplates::isSingleTemplateUrl()
 */
function instapageWPSEORobots() {
  ob_start();
  $templates = new \Instapage\Classes\Templates\ClassTemplates();
  $wpseoFrontend = WPSEO_Frontend::get_instance();
  $wpseoFrontend->robots();
  $output = ob_get_contents();
  $output = str_replace([',noodp', 'noodp'], '', $output);

  if (
    (!is_date() && is_archive()) ||
    is_home() ||
    is_author() ||
    is_category() ||
    isSeoPage() ||
    $templates->isSingleTemplateUrl()
  ) {
    $output = '';
  }

  if (isset($_GET['s'])) {
    $output = '<meta name="robots" content="noindex,nofollow"/>' . "\n";
  }

  ob_end_clean();
  echo $output;
}

function instapageWPSEOCanonical( $canonical )
{
  if ( is_date() || removeCanonical() )
  {
    $canonical = '';
  }

  return $canonical;
}

function instapageWPSEOOpengraph( $url )
{
  if( $url )
  {
    return $url;
  }

  global $wp;

  return home_url( add_query_arg( array(), $wp->request ) );
}

function purgeFacebookCache( $ID, $post ) {

  $fbUrl = 'https://graph.facebook.com';
  $pageUrl = get_permalink( $ID );
  wp_remote_post(
    $fbUrl,
    array
    (
      'body' => array
      (
        'id' => get_permalink( $ID ),
        'scrape' => 'true'
      )
    )
  );
}

function instapageDisableSearchJsonLd()
{
  return false;
}

function instapageAdminCss()
{
  wp_register_style( 'instapage-admin-style', get_template_directory_uri() . '/assets/css/admin.css', false, '1.0.0' );
  wp_enqueue_style( 'instapage-admin-style' );
}

function addVideoProviders() {
  $endpoints = [
    '#https?://www\.facebook\.com/video.php.*#i' => 'https://www.facebook.com/plugins/video/oembed.json/',
    '#https?://www\.facebook\.com/.*/videos/.*#i' => 'https://www.facebook.com/plugins/video/oembed.json/',
    '#https?://www\.facebook\.com/.*/posts/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/.*/activity/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/photo(s/|.php).*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/permalink.php.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/media/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/questions/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/notes/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?:\/\/(.+)?(wistia.com|wi.st)\/(medias|embed)\/.*#' => 'http://fast.wistia.com/oembed'
  ];

  foreach ($endpoints as $pattern => $endpoint) {
    wp_oembed_add_provider($pattern, $endpoint, true);
  }
}

function filterEmbededContent($cachedHtml) {

  $changes = [];
  $changes[] = ['pattern' => '/sandbox=".*?"/', 'replace' => 'sandbox="allow-same-origin allow-scripts"'];
  $changes[] = ['pattern' => '/style=".*?"/', 'replace' => ''];

  if (!empty($cachedHtml) && strpos('allowfullscreen', $cachedHtml) === false) {
    $changes[] = ['pattern' => '/<iframe/', 'replace' => '<iframe allowfullscreen'];
  }

  foreach ($changes as $change) {
    $cachedHtml = preg_replace($change['pattern'], $change['replace'], $cachedHtml);
  }

  return $cachedHtml;
}

function instapageSocialWidget( $template, $settings = null )
{
  $template_data = getShareButtonsData( $_POST, true );

  if( isset( $template_data->buttons_array[ 'email' ] ) && isset( $settings[ 'remove' ] ) && in_array( 'email', $settings[ 'remove' ] ) )
  {
    unset( $template_data->buttons_array[ 'email' ] );
  }

  $template_file = WP_PLUGIN_DIR . '/simple-share-buttons-adder/templates/' . $template . '.php';

  if( file_exists( $template_file ) )
  {
    include( $template_file );
  }
  else
  {
    echo __( 'Template ' . $template_file . ' does not exist' );
  }
}

function dequeueClickToTweetCss() {
  if (!is_single()) {
    wp_dequeue_style('tm_clicktotweet');
  }
}

function instapageConvertNumberToWord( $number )
{

  if ( !is_numeric( $number ) )
  {
    return false;
  }

  $dictionary = array
  (
    0 => __( 'zero' ),
    1 => __( 'one' ),
    2 => __( 'two' ),
    3 => __( 'three' ),
    4 => __( 'four' ),
    5 => __( 'five' ),
    6 => __( 'six' ),
    7 => __( 'seven' ),
    8 => __( 'eight' ),
    9 => __( 'nine' ),
    10 => __( 'ten' ),
    11 => __( 'eleven' ),
    12 => __( 'twelve' ),
    13 => __( 'thirteen' ),
    14 => __( 'fourteen' ),
    15 => __( 'fifteen' ),
    16 => __( 'sixteen' ),
    17 => __( 'seventeen' ),
    18 => __( 'eighteen' ),
    19 => __( 'nineteen' ),
    20 => __( 'twenty' )
  );

  return getVar( $dictionary[ (int)$number ], (int)$number );
}

function getVar( $value, $default = false )
{

  if( isset( $value) )
  {
    return $value;
  }

  return $default;
}

function isChapterListing()
{
  global $post;

  $chapter_pattern = '/.*?-chapter-[0-9]+/';

  if ( $post->post_type == 'seo-page' && !preg_match( $chapter_pattern, $post->post_name ) )
  {
    return true;
  }

  return false;
}

function instapageParseRequest($query) {
  /* @var $amp \Instapage\Classes\Amp\Amp */
  global $amp;

  $qv = wp_parse_args($query);

  if (isset($qv['query_vars']['error']) && $qv['query_vars']['error'] === '404') {
    $slug = $qv['request'];

    if (
      \Instapage\Classes\CustomSitemap\CustomSitemap::getInstance()->isSitemap(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) ||
      \Instapage\Classes\Templates\ClassTemplates::isSingleTemplatePatternMatched()
    ) {
      unset($query->query_vars['error']);
      unset($query->query_vars['page']);
      unset($query->query_vars['pagename']);

      return $query;
    } else if ($amp->isEnabled() && $postType = $amp->getPostTypeBasedOnAmpSlug('/' . $slug)) {
      $slug = $amp->stripAmpSlug('/' . $slug);
      $conditions = ['name' => $slug, 'post_type' => $postType];
    } else {
      $conditions = ['post_type' => ['seo-page'], 'name' => $slug];
    }

    $posts = get_posts($conditions);

    if ($posts) {
      $post = array_pop($posts);

      unset($query->query_vars['error']);
      unset($query->query_vars['page']);
      unset($query->query_vars['pagename']);

      $query->query_vars['post_type'] = $post->post_type;
      $query->query_vars['name'] = $slug;

      /**
       *
       * Here were also two additional query_vars set, they look like this:
       *  $query->query_vars[$post->post_type] = $slug;
       *  $query->query_vars['pagename'] = $slug;
       *
       * But in context of this function, they shouldn't be set. Why?
       * Because when we set ['pagename'] and  $query->query_vars[$post->post_type] there was
       * a query for page by name set in $slug and if there was a page of given slug SQL WHERE
       * condition where formed to ask for post by id of that page, and post type something
       * diffrent than page, so 404 was returned.
       */
    }
  }

  return $query;
}

/**
 * Performs a simple healthcheck of the website. Checks DB connection.
 */
function performHealthcheck() {
  global $wpdb;
  global $wp_query;
  $success = true;

  $requestHeaders = getallheaders();

  //DB Connection test
  $sql = sprintf('SELECT ID FROM %s LIMIT 1', $wpdb->posts);

  if ($wpdb->query($sql) === false) {
    $success = false;
  }

  if ($success) {
    if (!headers_sent()) {
      header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK', true, 200);
    }
    echo 'OK';
    die();
  }

  if (!headers_sent()) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    die();
  }
}

/**
 * Create object for SEO Page model and find out if pagination is out of range?
 *
 * @param string $pageNumber Current page number from the request
 * @return boolean True if pagination is out of range
 */
function checkIfGuidesPaginationIsOutOfRange($pageNumber = 1) {
  $model = new \Instapage\Models\SeoPage;
  $maxGuidesPageNumber = $model->getMaxPageNumberInPagination();
  return $pageNumber > $maxGuidesPageNumber;
}

function instapageRequestFilter($query) {
	global $wp_query;

	$qv = wp_parse_args($query);
	$request = getVar($qv['request']);
	$invalid_page_pattern = '/page[0-9]+$/';
	$paged_home_pattern = '/^page\/[0-9]+$/';
	$requestUri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field($_SERVER[ 'REQUEST_URI']) : '';
	$paramsLocation = mb_strpos( $requestUri, '?' );

	if ($request === 'healthcheck') {
		performHealthcheck();
	}

 	if( $paramsLocation !== false )
	{
		$requestUri = mb_substr( $requestUri, 0, $paramsLocation );
	}

	$uppercasePattern = '/[A-Z]/';

	if (
		!is_admin() &&
		$requestUri &&
		$requestUri !== '/' &&
		preg_match( $uppercasePattern, $requestUri )
	) {

		$redirectUrl = get_site_url() . strtolower($requestUri);

		if( $paramsLocation !== false )
		{
			$redirectUrl .= '?' . http_build_query($_GET);
		}

		wp_redirect($redirectUrl, 301);
		exit();
	}

	$qv_page = isset($qv['query_vars']['page']) ? $qv['query_vars']['page'] : '';
	$post_id = isset($qv['query_vars']['p']) ? $qv['query_vars']['p'] : '';
  $author_id = $wp_query->query_vars['author'] ?? null;

  if (is_front_page()) {
    $staticFrontPageID = (int) get_option('page_on_front');
    $staticFrontPageSlug = get_post_field('post_name', $staticFrontPageID, 'raw');
  }

	$old_author_names = [
		'dusti',
		'bsun',
		'igor',
		'brandon',
		'travisbliffen',
		'sujan',
		'sherice',
		'daniel',
		'noahk',
		'fahad-muhammed',
		'kevin'
	];

	$removed_authors = [
		'piotrdolistowski',
		'mariuszpolinski',
		'tomasz-jozwik',
		'marek',
		'pawel',
		'chris',
		'chrisg',
		'andrewpage',
		'ivanstyle'
	];

	if(
    (isset($qv['query_vars']['pagename']) && (strpos($qv['query_vars']['pagename'], '.') !== false) && !\Instapage\Classes\CustomSitemap\CustomSitemap::getInstance()->isSitemap($_SERVER['REQUEST_URI'])) ||
    (isset($qv['request']) && (strpos($qv['request'], 'author/admin') !== false || preg_match('/^.*?\/page\/1$/', $qv['request']) == 1)) ||
    (isset($qv['request']) && (stripos($qv['request'], '-') === 0)) ||
    (isset($qv['request']) && (strripos($qv['request'], '-') === strlen($qv[ 'request']) - 1)) ||
    (isset($qv['request']) && (stripos($qv['request'], '--') !== false)) ||
    (isset($qv['request']) && (stripos($requestUri, '//') !== false)) ||
    (preg_match($invalid_page_pattern, $request) && isset($qv['query_vars']['paged'])) ||
    ((is_single() || is_page()) && isset($qv['query_vars']['paged'])) ||
    (preg_match($paged_home_pattern, $request)) && !isset($qv['query_vars']['s']) ||
    (in_array(getVar($qv['query_vars']['author_name']), $old_author_names)) ||
    (in_array(getVar($qv['query_vars']['author_name']), $removed_authors)) ||
    (!empty($author_id) && countUserPosts($author_id) === 0) ||
    (getVar($qv['query_vars']['author_name']) === 'fahad' && getVar($qv['query_vars']['paged'])) ||
    (getVar($qv['query_vars']['taxonomy']) === 'seo_section') ||
    (getVar($qv['query_vars']['post_type']) === 'features' && !empty(getVar($qv['query_vars']['features']))) ||
    (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] === '/affiliates') ||
    (preg_match('/^guides\/.+/', $qv['request']) == 1 && ( strpos($qv['request'], 'guides/page/') !== 0 || checkIfGuidesPaginationIsOutOfRange(intval($query->query_vars['paged'])))) ||
    (isset($qv['query_vars']['tb']) && $qv['query_vars']['tb'] == 1) ||
    (Ebook::isEbook() && is_single()) ||
    (Product::isProduct() && !is_single()) ||
    (\Instapage\Classes\Templates\ClassTemplates::isSingleTemplatePatternMatched() && !\Instapage\Classes\Templates\ClassTemplates::getInstance()->isSingleTemplateUrl(false)) ||
    (strpos(getVar($qv['query_vars']['author_name']), '.') !== false) ||
    (is_front_page() && isset($qv['request']) && $qv['request'] === $staticFrontPageSlug)
	)
	{
		$wp_query->set_404();
	}

  return $query;
}

/**
 * Returns number of publised posts by given $userID with given $postType
 * @param  int $userID User ID
 * @param  string $postType Post type name
 * @return int Number of published posts by this user
 */
function countUserPosts($userID, $postType = 'post') {
  global $wpdb;

  $userID = intval($userID);
  $result = $wpdb->get_results("SELECT COUNT(1) as `count` FROM `{$wpdb->posts}` WHERE `post_author` = " . $userID . " AND `post_type` = '" . $postType . "' AND `post_status` = 'publish'", OBJECT);
  return (isset($result[0]) && (is_object($result[0]))) ? intval($result[0]->count) : 0;
}

/**
 * Fetches all authors which has at least one post of given post type and returs their ID`s
 * @param  string $postType Post type, default is `post`
 * @return array Array of ID`s
 * @see    hasAuthorPosts()
 */
function countAuthorsPosts($postType = 'post') {
  global $wpdb;

  $items = [];
  $postType = esc_sql($postType);

  $results = $wpdb->get_results("SELECT DISTINCT `post_author` FROM `{$wpdb->posts}` WHERE `post_type` = '" . $postType . "' AND `post_status` = 'publish'", OBJECT);
  if (isset($results) && !empty($results)) {
    foreach ($results as $result) {
      $items[] = (int) $result->post_author;
    }
  }

  return $items;
}

/**
 * Checks if given user has posts in given post type
 * @param  int $userID User ID
 * @param  string $postType Post type, default is `post`
 * @uses   countAuthorsPosts()
 * @uses   \Instapage\Classes\Factory::getCache()
 * @return bool True if given user has at least one post of given post type
 */
function hasAuthorPosts($userID, $postType = 'post') {
  $userID = intval($userID);
  $postType = esc_sql($postType);
  $cacheKey = 'authors_with_posts_' . $postType;
  $cache = \Instapage\Classes\Factory::getCache();
  $authors = $cache::get($cacheKey);
  if ($authors === false) {
    $authors = countAuthorsPosts($postType);
    $cache::set($cacheKey, $authors);
  }

  return in_array($userID, $authors);
}

/**
 * Register an action to refresh cache every time post is published
 */
add_action(
  'publish_post',
  function() {
    $cache = \Instapage\Classes\Factory::getCache();
    $cache::set('authors_with_posts_post', countAuthorsPosts());
  },
  20,
  2
);

function disableTags()
{
  unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

function disableTagsUrls()
{
  if( is_tag() )
  {
    global $wp_query;
    $wp_query->set_404();
  }
}

function changeAuthorPermalinks()
{
  global $wp_rewrite;

  $wp_rewrite->author_base = 'author';
  $wp_rewrite->author_structure = '/' . $wp_rewrite->author_base. '/%author%';
}

function instapageSeoRules()
{
  global $wp_query;

  $users = get_users();

  foreach( $users as $user )
  {
    $user_data = get_userdata( $user->ID );
    $nice_name = $user_data->data->user_nicename;
    $nice_nickname = sanitize_title( get_user_meta( $user->ID, 'nickname', true ) );

    if( $nice_name != $nice_nickname )
    {
			add_rewrite_rule( '^author/' . $nice_nickname . '(/)?$', 'index.php?author=' . $user->ID, 'top' );
			add_rewrite_rule( '^author/' . $nice_nickname . '/page/([0-9]+)', 'index.php?author=' . $user->ID . '&paged=$matches[1]', 'top' );
			add_rewrite_rule( '^author/' . $nice_name . '$', 'index.php?error=404', 'top' );
		}
	}

	add_rewrite_rule( '^blog/10-simple-ab-tests-landing-page-infographic/?$', 'index.php?p=6701', 'top' );
	add_rewrite_rule( '^blog/3-crucial-elements-for-effective-mobile-landing-pages/?$', 'index.php?p=3645', 'top' );
	add_rewrite_rule( '^blog/3-incredibly-effective-facebook-ad-examples/?$', 'index.php?p=12890', 'top' );
	add_rewrite_rule( '^blog/4-mobile-landing-page-friction-points-and-how-to-get-around-them/?$', 'index.php?p=13072', 'top' );
	add_rewrite_rule( '^blog/5-elements-of-a-winning-sales-page-template/?$', 'index.php?p=3567', 'top' );
	add_rewrite_rule( '^blog/5-landing-pages-utilizing-best-practices/?$', 'index.php?p=2638', 'top' );
	add_rewrite_rule( '^blog/6-incredibly-effective-call-to-action-examples/?$', 'index.php?p=2326', 'top' );
	add_rewrite_rule( '^blog/6-reasons-why-image-sliders-are-bad-for-conversions/?$', 'index.php?p=11158', 'top' );
	add_rewrite_rule( '^blog/6-simple-tips-for-creating-effective-call-to-action-buttons/?$', 'index.php?p=10264', 'top' );
	add_rewrite_rule( '^blog/7-new-features/?$', 'index.php?p=7782', 'top' );
	add_rewrite_rule( '^blog/8-critical-elements-to-ab-test-on-your-landing-pages/?$', 'index.php?p=10540', 'top' );
	add_rewrite_rule( '^blog/activecampaign-integration/?$', 'index.php?p=11440', 'top' );
	add_rewrite_rule( '^blog/art-of-persuasion/?$', 'index.php?p=11924', 'top' );
	add_rewrite_rule( '^blog/aweber-integration/?$', 'index.php?p=7683', 'top' );
	add_rewrite_rule( '^blog/aweber-landing-pages/?$', 'index.php?p=7871', 'top' );
	add_rewrite_rule( '^blog/buyer-personas/?$', 'index.php?p=10891', 'top' );
	add_rewrite_rule( '^blog/call-to-action-above-or-below-fold/?$', 'index.php?p=5578', 'top' );
	add_rewrite_rule( '^blog/coming-soon-landing-page-examples/?$', 'index.php?p=12898', 'top' );
	add_rewrite_rule( '^blog/content-marketers-guide-to-landing-page-optimization/?$', 'index.php?p=11532', 'top' );
	add_rewrite_rule( '^blog/crucial-elements-for-high-performing-landing-pages/?$', 'index.php?p=10346', 'top' );
	add_rewrite_rule( '^blog/crucial-elements-for-high-performing-landing-pages?page=2/?$', 'index.php?p=13219', 'top' );
	add_rewrite_rule( '^blog/editing-images/?$', 'index.php?p=7821', 'top' );
	add_rewrite_rule( '^blog/google-adwords-mistakes/?$', 'index.php?p=13078', 'top' );
	add_rewrite_rule( '^blog/gotowebinar-integration/?$', 'index.php?p=12650', 'top' );
	add_rewrite_rule( '^blog/growth-hackers-guide-landing-page-optimization/?$', 'index.php?p=11171', 'top' );
	add_rewrite_rule( '^blog/how-to-build-an-effective-affiliate-landing-page/?$', 'index.php?p=3945', 'top' );
	add_rewrite_rule( '^blog/how-to-build-seo-friendly-landing-pages/?$', 'index.php?p=4039', 'top' );
	add_rewrite_rule( '^blog/how-to-create-a-facebook-landing-page/?$', 'index.php?p=11435', 'top' );
	add_rewrite_rule( '^blog/how-to-create-an-effective-call-to-action/?$', 'index.php?p=12481', 'top' );
	add_rewrite_rule( '^blog/how-to-create-an-effective-call-to-action/page/2/?$', 'index.php?p=10262', 'top' );
	add_rewrite_rule( '^blog/how-to-design-your-pricing-page-for-maximum-conversions/?$', 'index.php?p=11156', 'top' );
	add_rewrite_rule( '^blog/how-to-ensure-a-smooth-adwords-landing-page-experience/?$', 'index.php?p=3318', 'top' );
	add_rewrite_rule( '^blog/how-to-get-google-to-like-your-landing-pages/?$', 'index.php?p=1115', 'top' );
	add_rewrite_rule( '^blog/how-to-get-more-webinar-signups/?$', 'index.php?p=11910', 'top' );
	add_rewrite_rule( '^blog/how-to-promote-your-landing-pages-with-facebook-ads/?$', 'index.php?p=11595', 'top' );
	add_rewrite_rule( '^blog/how-to-publish-a-landing-page-on-wordpress/?$', 'index.php?p=12662', 'top' );
	add_rewrite_rule( '^blog/how-to-use-content-marketing-with-landing-pages/?$', 'index.php?p=9326', 'top' );
	add_rewrite_rule( '^blog/how-to-write-effective-landing-page-headlines/?$', 'index.php?p=9850', 'top' );
	add_rewrite_rule( '^blog/importing-templates/?$', 'index.php?p=11273', 'top' );
	add_rewrite_rule( '^blog/instapage-introduces-ab-split-testing/?$', 'index.php?p=6729', 'top' );
	add_rewrite_rule( '^blog/introduction-to-ab-testing-landing-pages/?$', 'index.php?p=6881', 'top' );
	add_rewrite_rule( '^blog/iphone-app-landing-pages/?$', 'index.php?p=7235', 'top' );
	add_rewrite_rule( '^blog/landing-page-best-practices-2014/?$', 'index.php?p=10562', 'top' );
	add_rewrite_rule( '^blog/landing-page-checklist-infographic/?$', 'index.php?p=10912', 'top' );
	add_rewrite_rule( '^blog/landing-page-examples-that-break-all-the-rules/?$', 'index.php?p=11918', 'top' );
	add_rewrite_rule( '^blog/landing-page-grouping/?$', 'index.php?p=7937', 'top' );
	add_rewrite_rule( '^blog/landing-page-headlines-utilize-3-key-characteristics/?$', 'index.php?p=2420', 'top' );
	add_rewrite_rule( '^blog/landing-page-optimization-infographic/?$', 'index.php?p=6326', 'top' );
	add_rewrite_rule( '^blog/landing-page-psychology/?$', 'index.php?p=9593', 'top' );
	add_rewrite_rule( '^blog/landing-page-software-instapage-utilizes/?$', 'index.php?p=11437', 'top' );
	add_rewrite_rule( '^blog/landing-page-tutorial/?$', 'index.php?p=7501', 'top' );
	add_rewrite_rule( '^blog/lpo-and-cro-explained/?$', 'index.php?p=7767', 'top' );
	add_rewrite_rule( '^blog/mailchimp-integration/?$', 'index.php?p=5609', 'top' );
	add_rewrite_rule( '^blog/mailchimp-landing-page/?$', 'index.php?p=7186', 'top' );
	add_rewrite_rule( '^blog/maslows-hierarchy-of-needs/?$', 'index.php?p=11913', 'top' );
	add_rewrite_rule( '^blog/mobile-app-landing-page-examples/?$', 'index.php?p=11909', 'top' );
	add_rewrite_rule( '^blog/new-feature-edit-live-pages/?$', 'index.php?p=4409', 'top' );
	add_rewrite_rule( '^blog/obama-vs-romney-landing-pages-dissected/?$', 'index.php?p=4437', 'top' );
	add_rewrite_rule( '^blog/pop-up-ads/?$', 'index.php?p=9569', 'top' );
	add_rewrite_rule( '^blog/pop-up-advertising/?$', 'index.php?p=10689', 'top' );
	add_rewrite_rule( '^blog/pop-up-forms/?$', 'index.php?p=10456', 'top' );
	add_rewrite_rule( '^blog/saas-landing-pages/?$', 'index.php?p=11002', 'top' );
	add_rewrite_rule( '^blog/thank-you-landing-pages/?$', 'index.php?p=10665', 'top' );
	add_rewrite_rule( '^blog/the-definitive-guide-to-landing-pages/?$', 'index.php?p=12474', 'top' );
	add_rewrite_rule( '^blog/these-4-ab-tests-increased-instapage-signups-by-34-percent/?$', 'index.php?p=11441', 'top' );
	add_rewrite_rule( '^blog/top-10-content-marketing-mistakes-and-how-to-fix-them/?$', 'index.php?p=9752', 'top' );
	add_rewrite_rule( '^blog/top-3-reasons-why-ab-tests-fail/?$', 'index.php?p=10646', 'top' );
	add_rewrite_rule( '^blog/top-4-ways-to-create-anxiety-free-landing-pages/?$', 'index.php?p=10712', 'top' );
	add_rewrite_rule( '^blog/ultimate-guide-to-ab-split-testing/?$', 'index.php?p=10038', 'top' );
	add_rewrite_rule( '^blog/ultimate-guide-to-creating-call-to-actions/?$', 'index.php?p=9892', 'top' );
	add_rewrite_rule( '^blog/ultimate-landing-page-optimization-guide/?$', 'index.php?p=9514', 'top' );
	add_rewrite_rule( '^blog/ultimate-landing-page-optimization-guide/page/2/?$', 'index.php?p=10119', 'top' );
	add_rewrite_rule( '^blog/webinar-landing-pages/?$', 'index.php?p=10947', 'top' );
	add_rewrite_rule( '^blog/welcome-email-strategies/?$', 'index.php?p=11643', 'top' );
	add_rewrite_rule( '^blog/what-is-an-android-landing-page/?$', 'index.php?p=3465', 'top' );
	add_rewrite_rule( '^blog/what-is-a-pitch-page/?$', 'index.php?p=7096', 'top' );
	add_rewrite_rule( '^blog/what-is-a-ppc-landing-page/?$', 'index.php?p=12075', 'top' );
	add_rewrite_rule( '^blog/what-is-a-promotion/?$', 'index.php?p=11439', 'top' );
	add_rewrite_rule( '^blog/what-is-interactive-content-marketing/?$', 'index.php?p=10991', 'top' );
	add_rewrite_rule( '^blog/what-not-to-do-with-your-real-estate-landing-pages/?$', 'index.php?p=11920', 'top' );
	add_rewrite_rule( '^blog/what-to-ab-test-on-landing-pages/?$', 'index.php?p=6916', 'top' );
	add_rewrite_rule( '^blog/wordpress-landing-page-plugin/?$', 'index.php?p=7367', 'top' );
	add_rewrite_rule( '^cool-landing-pages/?$', 'index.php?p=3908', 'top' );
	add_rewrite_rule( '^how-to-get-started-with-a-landing-page/?$', 'index.php?p=12836', 'top' );
	add_rewrite_rule( '^how-to-get-started-with-a-landing-page/page/2/?$', 'index.php?p=13481', 'top' );
	add_rewrite_rule( '^landing-pages-that-convert/?$', 'index.php?p=7956', 'top' );
}

function getCSSPath($cssFile, $type = 'template') {
  switch ($type) {
    case 'v5-template':
      $path = get_template_directory() . '/v5/assets/css/' . $cssFile;
      break;
    case 'template':
      $path = get_template_directory() . '/assets/css/' . $cssFile;
      break;
    case 'plugin':
      $path = ABSPATH . '/wp-content/plugins/' . $cssFile;
      break;
    case 'path':
      $path = $cssFile;
      break;
    default:
      $path = ABSPATH . '/' . $cssFile;
  }

  return $path;
}

function enqueueInstapageStyles() {
  global $post;

  $useTopfoldCss = (defined('V5_USE_TOPFOLD_CSS') && V5_USE_TOPFOLD_CSS === true) ? true : false;
  $styles = [];

  if (isAmp()) {
    $styles[] = ['amp.min.css', 'v5-template'];
  } elseif ($useTopfoldCss) {
    $styles[] = ['topfold51.min.css', 'v5-template'];
  } else {
    wp_enqueue_style('topfold', get_template_directory_uri() . '/v5/assets/css/topfold51.min.css');
  }
  wp_enqueue_style('ui', get_template_directory_uri() . '/v5/assets/css/styles51.min.css');

  if (!empty($styles)) {
    replaceRelativePaths($styles);
  }
}

function replaceRelativePaths($styleFiles, $outputStyleTag = true) {
  $root = get_template_directory_uri() . '/';
  $replacements = [
    'v5-template' => [
      '../../../assets/images' => $root . 'assets/images',
      '../images' => $root . 'v5/assets/images',
      '../assets/images' => $root . 'v5/assets/images',
      '../fonts' => $root . 'v5/assets/fonts'
    ],
    'other' => [
      '../images' => $root . 'assets/images'
    ]
  ];

  foreach ($styleFiles as $styleFile) {
      $file = $styleFile[0];
      $type = $styleFile[1];
      $path = getCSSPath($file, $type);
      $data = file_get_contents($path);

      switch ($type) {
        case 'template':
        case 'v5-template':
          $data = str_replace(
            array_keys($replacements[$type]),
            array_values($replacements[$type]),
            $data
          );
          break;
        default:
          $data = str_replace(
            array_keys($replacements['other']),
            array_values($replacements['other']),
            $data
          );
      }
      echo $outputStyleTag ? '<style type="text/css" media="all">' . $data . '</style>' : $data;
  }
}

/**
 * Registers and enqueues the scripts needed for Instapage template.
 * "jquery-migrate" isn't necessary for our template, but WP plugins tend to use functions from native jQuery v 1.12 (native for WP).
 */
function instapageScripts() {

  global $post;

  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', get_template_directory_uri() . '/v5/assets/js/v51/scripts.min.js', null, null, true);
  wp_enqueue_script('jquery-migrate', '', ['jquery'], null, true);
  wp_enqueue_script('lazyload', get_template_directory_uri() . '/v5/assets/js/v51/src/libs/lazysizes.min.js', null, null, true);
}

function excerptMoreLink( $more )
{
  return '<a href="' . get_permalink() . '" class="excerpt-more">' .__( 'Read More' ) . ' &gt;</a>';
}

function addInstapagePostStatuses()
{
  $data = array(
    'label' => _x( 'Stash', 'post' ),
    'public' => false,
    'exclude_from_search' => true,
    'show_in_admin_all_list' => true,
    'show_in_admin_status_list' => true,
    'label_count' => _n_noop( 'Stash <span class="count">(%s)</span>', 'Stash <span class="count">(%s)</span>' )
  );

  register_post_status( 'stash', $data );
}

function appendInstapagePostStatuses(){

  global $post;
  $complete = '';
  $label = '';

  if( $post->post_type == 'post' )
  {
    if( $post->post_status == 'stash' )
    {
      $complete = ' selected=\"selected\"';
      $label = '<span id=\"post-status-display\"> ' . __( 'Stashed' ) . '</span>';
    }

    echo '
    <script>
    jQuery( document ).ready( function( $ ) {
      $( "select#post_status" ).append( "<option value=\"stash\" ' . $complete . '>' . __( 'Stash' ) . '</option>" );
      $( ".misc-pub-section label" ).append( "' . $label . '" );
    } );
    </script>
    ';
  }
}

function featuredImageInRss($content)
{
  global $post;

  if ( has_post_thumbnail( $post->ID ) )
  {
    $img = get_the_post_thumbnail( $post->ID, 'rss-thumb', array( 'style' => 'margin-bottom: 10px;', 'alt' => '' ) );
    $img = preg_replace( '~(.*?)height=".*?"(.*?)~', '$1 height="auto" $2', $img );
    $content = '<a href="' . get_permalink() . '">' . $img . '</a>' . '<br>' . $content;
  }

  return $content;
}

/**
 * Returns a string representation of a placeholder for images.
 * @param  string $template Name of the template. Different templates can have different placeholders.
 * @return string A placeholder.
 */
function getImagePlaceholder($template = null) {
  if ($template === 'templates') {
    return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMTEzLjQgODUiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDExMy40IDg1OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHN0eWxlIHR5cGU9InRleHQvY3NzIj4uc3Qwe2ZpbGw6I0M2QzZDNjt9PC9zdHlsZT48cmVjdCBjbGFzcz0ic3QwIiB3aWR0aD0iMTEzLjQiIGhlaWdodD0iODUiLz48L3N2Zz4=';
  }

  return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC';
}

/**
 * Cleans the output of DOMDocument::saveHTML function. This should be done by adding LIBXML_HTML_NOIMPLIED as a param of DOMDocument::loadHTML function, but it breaks the HTML.
 * @param string $content Content, output of DOMDocument::saveHTML function.
 * @return  string Cleaned content without <html><body> wrapping.
 */
function removeHtmlWrapper($content) {
  $htmlStart = '<html><body>';
  $htmlEnd = '</body></html>';
  $trimmedContent = trim($content);

  if (strpos($trimmedContent, $htmlStart) === 0 ) {
    $content = mb_substr($trimmedContent, strlen($htmlStart), - strlen($htmlEnd));
  }

  return $content;
}

/**
 * Replaces the images src and srcset with data-src and data-srcset equivalents for lazysizes.min.js library, to enable lazy loading.
 *
 * @param  string $content HTML of the post.
 * @return string Parsed content.
 */
function lazyloadImageReplace($content) {
  global $amp;

  if (empty($content) || $amp->isEnabled()) {
    return $content;
  }

  libxml_use_internal_errors(true);
  // base 64 encoded gray placeholder
  $placeholder = getImagePlaceholder();
  $doc = new DOMDocument('1.0', 'UTF-8');
  $doc->encoding = 'UTF-8';
  // Do not use LIBXML_HTML_NOIMPLIED option here, it breaks HTML.
  $doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NODEFDTD);

  if ($doc === false) {
    error_log('HTML loading failed. Image lazyloading disabled.');
    return $content;
  }

  $images = $doc->getElementsByTagName('img');

  if (empty($images)) {
    return $content;
  }

  foreach ($images as $image) {
    $src = $image->getAttribute('src');
    $srcset = $image->getAttribute('srcset');
    $image->setAttribute('src', $placeholder);
    $image->removeAttribute('srcset');
    $image->setAttribute('data-original', $src);
    $image->setAttribute('data-src', $src);
    $image->setAttribute('data-srcset', $srcset);
    $image->setAttribute('class', $image->getAttribute('class') . ' lazy lazyload');
  }

  $content = removeHtmlWrapper($doc->saveHTML());

  return $content;
}

/**
 * Removes version parameter from enqueued scripts. Required for proper script caching.
 *
 * @param string $src Source of the script.
 * @return string Source without version parameter.
 */
function vcRemoveWpVerCssJs($src) {
  if (strpos($src, 'ver=')) {
    $src = remove_query_arg('ver', $src);
  }

  return $src;
}

function displayPostCategoriesWithLinks( $post_id )
{
  $html = array();
  $categories = get_the_category( $post_id );

  if ( empty( $categories ) )
  {
    return false;
  }

  foreach( $categories as $category )
  {
    $html[] = '<a href="' . get_category_link( $category->term_id ) . '">' . $category->cat_name . '</a>';
  }

  return implode( ', ', $html );
}

function displayPostTags( $tags )
{
  $html = array();

  if ( empty( $tags ) )
  {
    return false;
  }

  foreach( $tags as $tag )
  {
    $html[] = '<a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a>';
  }

  return implode( ', ', $html );
}

function responsiveVideoEmbed($embed, $attr, $url, $rawattr) {
  $embed = '<div class="wp-responsive-embed">' . $embed . '</div>';
  return $embed;
}

function getBetween( $start, $end, $string )
{
  $array = explode( $start, $string );
  array_shift( $array );

  foreach( $array as $part )
  {
    $part = explode( $end, $part );
    $output[] = trim( $part[0] );
  }

  if( is_array( $output ) and count( $output ) == 1 )
  {
    return $output[0];
  }

  return $output;
}

function isStatic()
{
  global $post;

  return get_post_meta( $post->ID, 'is_static', true );
}

/**
 * Do we need to remove canonical tag from current page?
 *
 * @return boolean Do we need to remove canonical from currently rendering content?
 */
function removeCanonical() {
  return (boolean) get_field('remove_canonical');
}

function register_my_menus()
{
  register_nav_menus
  (
    array
    (
      'top-menu' => __( 'Top Menu' ),
      'top-menu-right' => __( 'Top Menu Right' ),
      'footer-instapage-menu' => __( 'Footer Instapage Menu' ),
      'footer-support-menu' => __( 'Footer Support Menu' ),
      'footer-connect-menu' => __( 'Footer Connect Menu' ),
      'footer-resources-menu' => __( 'Footer Resources Menu' ),
      'footer-resources-menu-2' => __( 'Footer Resources Menu 2' ),
      'side-features-menu' => __( 'Side Features Menu' ),

      'v5-top-menu'              => __('v5 Top Menu'),
      'v5-top-menu-right'        => __('v5 Top Menu Right'),
      'v5-footer-product-menu'   => __( 'v5 Footer Product Menu' ),
      'v5-footer-resource-menu'  => __( 'v5 Footer Resource Menu' ),
      'v5-footer-support-menu'   => __( 'v5 Footer Support Menu' ),
      'v5-footer-company-menu'   => __( 'v5 Footer Company Menu' ),
      'v5-footer-partners-menu'  => __( 'v5 Footer Partners Menu' ),
      'v5-footer-follow-us-menu' => __( 'v5 Footer Follow Us Menu' )
    )
  );
}

/**
 * Returns an array of items to be displayed in menu
 * @param  string $menuSlug
 * @uses   \Instapage\Classes\Factory::getCache()
 * @uses   \Instapage\Helpers\StringHelper::parseUrl()
 * @uses   \Instapage\Helpers\StringHelper::unParseUrl()
 * @return array
 */
function getV5Menu($menuSlug) {
  $cacheKey = 'menu_' . $menuSlug;
  $cache = \Instapage\Classes\Factory::getCache();
  $data = $cache::get($cacheKey);
  if ($data === false) {

    if (($locations = get_nav_menu_locations()) && (isset($locations[$menuSlug]))) {
      $menu = wp_get_nav_menu_object($locations[$menuSlug]);
      $data = (array) wp_get_nav_menu_items($menu->term_id);
      $data = getChildNodes($data);
      $cache::set($cacheKey, $data);
      return $data;
    }

    return [];
  }

  return $data;
}

function getChildNodes($input = [], $id = 0) {
  $output = [];

  foreach ($input as $item) {
    $item = (array) $item;
    if ($id == $item['menu_item_parent']) {
      $item['child_nodes'] = getChildNodes($input, $item['ID']);
      $output[$item['ID']] = $item;
     }
   }

  return $output;
}


/**
 * Refreshes cached navigation menus
 * @uses   getV5Menu()
 * @uses   \Instapage\Classes\Factory::getCache()
 * @return void
 */
function refreshV5Menus() {
  $menus = [
    'v5-top-menu',
    'v5-footer-product-menu',
    'v5-footer-resource-menu',
    'v5-footer-support-menu',
    'v5-footer-company-menu',
    'v5-footer-partners-menu',
    'v5-footer-follow-us-menu'
  ];

  $cache = \Instapage\Classes\Factory::getCache();
  foreach ($menus as $menu) {
    $cache::delete('menu_' . $menu);
    getV5Menu($menu);
  }
}

/**
 * Used by `50/top-menu` component
 */
function getLayout($rootNode = []) {
  if ((isset($rootNode['child_nodes'])) && (is_array($rootNode['child_nodes'])) && (!empty($rootNode['child_nodes']))) {
    foreach ($rootNode['child_nodes'] as $childNode) {
      if ((isset($childNode['child_nodes'])) && (is_array($childNode['child_nodes'])) && (!empty($childNode['child_nodes']))) {
        return 'multi';
      }
    }
  }

  return 'single';
}

function formatMeta( $meta, $sep )
{
  global $paged, $wp_query, $post;

  $meta = trim( str_replace( ' - ' . __( 'Page' ) . ' 1 ' . __( 'of' ) . ' ' . $wp_query->max_num_pages, '', $meta ) );

  if ( $wp_query->max_num_pages >= 2 )
  {
    if ( $paged == 0 )
    {
      $paged = 1;
    }

    if ( ( is_author() || is_archive() ) && $paged > 1 )
    {
      $meta .= $sep . __( 'Page' ) . ' ' . $paged . ' ' . __( 'of' ) . ' ' . $wp_query->max_num_pages ;
    }

    if ( isset( $wp_query->query[ 'pagename' ] ) && $wp_query->query[ 'pagename' ] == 'blog' && $paged > 1 )
    {
      $meta .= $sep . __( 'Page' ) . ' ' . $paged . ' ' . __( 'of' ) . ' ' . $wp_query->max_num_pages;
    }
  }

  return $meta;
}

/**
 * Overwrites a title filter from Yeost SEO plugin.
 * @param  string $title Title passed to a filter.
 * @param  string $sep Separator between page's name and site's name.
 * @return string Filtered title.
 */
function instapageSeoTitle($title, $sep) {
  global $wp_filter, $wp_query, $post;
  $newTitle = '';

  if ((is_archive() && $post->post_type !== 'dictionary-term') || is_page() || is_blog_page() || isSeoPage() || is_single()) {
    //yeost title has random generated function title and priority 15, we have to remove it
    if (isset($wp_filter['wp_title'][15]) && is_array($wp_filter['wp_title'][15])) {
      $callbackIds = array_keys($wp_filter['wp_title'][15]);

      foreach ($callbackIds as $cid) {
        unset($wp_filter['wp_title']->callbacks[15][$cid]);
      }
    }

    //yoast title modification is disabled, but we need information from yoast extra field to replace default category title
    $object = $wp_query->get_queried_object();

    if (class_exists('WPSEO_Taxonomy_Meta')) {
      $newTitle = WPSEO_Taxonomy_Meta::get_term_meta($object, $object->taxonomy, 'title');
    }

    if (class_exists('WPSEO_Meta') && empty($newTitle) && !is_archive()) {
      $newTitle = WPSEO_Meta::get_value('title', $object->ID);
    }

    // we do not use yoast tags
    $patternToMatchYoastTags = '#%%[^%]+%%#'; // tag looks like %%tagname%%
    $newTitle = trim(preg_replace($patternToMatchYoastTags, '', $newTitle));

    /**
     * Page title set for custom page in SEO plugin has the priority over automatically
     * generated Page title.
     */
    if (isSeoPage() && !$newTitle) {
      $args = ['name' => null];
      $fields = getTaxonomyCustomField($args, 'seo_section');
      $title = getVar($fields['name']);
      $chapterNr = getChapterNr($post);

      if ($chapterNr) {
        $newTitle = $title . ' &#45; ' . __( 'Chapter' ) . ' ' . $chapterNr;
      } else {
        $newTitle = $title;
      }
    }

    if (empty($newTitle)) {
      $newTitle = $title;
    }
  }

  if (is_archive() && isSeoPage()) {
    $newTitle = __('Marketing Guides');
  }

  $newTitle = formatMeta($newTitle, ' - ');
  $pattern = '/(.*?)(- Instapage|\| Instapage|\|)$/';
  $replacement = '${1}';
  $newTitle = trim(preg_replace($pattern, $replacement, $newTitle));
  $incorrectSeparators = ['-', '–', '—', '|'];
  $newTitle = str_replace($incorrectSeparators, '&#45;', $newTitle);


  return $newTitle;
}

/**
 * Overrides meta description generated by Yoast plugin.
 * @param  string $desc Description generated by Yoast plugin
 * @uses   \Instapage\Classes\Templates\ClassTemplates::isSingleTemplatePatternMatched()
 * @return string New meta description.
 */
function instapageSeoDescription($desc) {
  global $paged, $wp_query;

  if (is_category()) {
    $desc = strip_tags(category_description());
  }

  if (is_author() && empty($desc)) {
    $authorName = get_the_author();
    $desc = sprintf(__('%s\'s blog on landing page optimization. Content includes examples on headlines, call-to-action, and marketing trends that increase conversions.'), $authorName);
  }

  $desc = formatMeta($desc, ' ');

  if ($wp_query->max_num_pages >= 2 && $paged > 1) {
    $desc .= '.';
  }

  if (is_date() || \Instapage\Classes\Templates\ClassTemplates::isSingleTemplatePatternMatched()) {
    $desc = '';
  }

  return $desc;
}

function instapageSeoAuthorLink( $link, $author_id, $author_nicename )
{
  $patterns = array( '/author/' . $author_nicename );
  $replacements = array( '/author/' . sanitize_title( get_the_author_meta( 'nickname', $author_id ) ) );
  $link = str_replace( $patterns, $replacements, $link );

  return $link;
}

function is_blog_page()
{

  if( !is_front_page() && is_home() )
  {
    return true;
  }

  return false;
}

function getTaxonomyCustomField( $fields = array(), $custom_post_type = 'post', $post_id = null )
{

  if( !$post_id )
    $post = get_post();
  else
    $post = get_post( $post_id );

  if( !$post || !function_exists( 'get_field' ) )
  {
    return false;
  }

  $terms = get_the_terms( $post->ID, $custom_post_type );
  $term = null;
  $data = array();

  if( is_array( $terms ) && !empty( $terms ) )
  {

    $term = array_pop( $terms );
    $data_arr = null;

    if( is_array( $fields ) )
    {
      foreach( $fields as $key => $property )
      {
        if( getVar( $term->$key, null ) )
        {
          $data[ $key ] = $term->$key;
        }
        else
        {
          $data_arr = get_field( $key, $term );
          $data[ $key ] = $property ? (isset($data_arr[$property]) ? $data_arr[$property] : null) : $data_arr;
        }
      }
    }
    else
    {
      return $term;
    }
  }

  return $data;
}

function trimTags( $html )
{

  $patterns = array(
    '/^(<br \/>|<p>|<\/p>)*(.*?)(<br \/>|<p>|<\/p>)$/s'
  );

  $html = preg_replace( $patterns, '$2', $html );

  return $html;
}

function roundShareNumberCallback( $matches )
{
  $social_media = getVar( $matches[ 2 ], '');
  $post_href = getVar( $matches[ 3 ], 0 );
  $social_media_class = '';

  switch( $social_media )
  {
    case 'google':
      $social_media_class = 'fa fa-google-plus';
      break;
    case 'email':
      $social_media_class = 'fa fa-envelope-o';
      break;
    default:
      $social_media_class = 'fa fa-' . $social_media;
      break;
  }

  $html = '';
  $shareCount = getVar( $matches[ 7 ], 0 );
  $html .= '<li>';
  $html .= '<a data-site="" class="ssba_' . $matches[ 2 ] . '_share" href="'. $post_href .'"  target="_blank"  rel="nofollow">';
  $html .= '<span class="social-button-wrapper">';
  $html .= '<i class="' . $social_media_class . '"></i>';
  $html .= '<span class="social-share-text">';
  $html .= getVar( $matches[ 4 ], '');
  $html .= '</span>';
  $html .= '</span>';
  $html .= '<span class="ssba_sharecount ' . $social_media . '-counter">';
  $html .= roundShareNumber( $shareCount );
  $html .= '</span>';
  $html .= '</a>';
  $html .= '</li>';

  return $html;
}

function getVideoURL( $term_id )
{
  $video_url = get_field( 'video_url', $term_id );

  if( !empty( $video_url ) )
  {
    return $video_url;
  }

  return false;
}

function getVideoEmbed( $term_id )
{
  $video_url = getVideoURL( $term_id );

  if( $video_url !== false )
  {
    global $wp_embed;
    $code = ' [embed]' . $video_url . '[/embed] ';
    $code = $wp_embed->run_shortcode( $code );
    return $code;
  }

  return '';
}

function custom_oembed_filter( $html, $url, $attr, $post_ID )
{
	$host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
	$domain = explode( '.', $host );
	$content = str_replace( 'width="500"', 'width="700"', $html);
	$content = str_replace( 'src=', 'class="lazy lazyload" data-src=', $html);
	$html_content = '<div class="video-responsive-wrapper"><div class="video-responsive video-' . $domain[ 0 ] . '"><div class="loader"></div>' . $content . '</div></div>';

  return $html_content;
}

// Re-add svg support removed in WP 4.7.1
add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
  global $wp_version;

  if ($wp_version == '4.7' || ((float) $wp_version < 4.7 )) {
    return $data;
  }

  $filetype = wp_check_filetype($filename, $mimes);

  return ['ext' => $filetype['ext'], 'type' => $filetype['type'], 'proper_filename' => $data['proper_filename']];
}, 10, 4 );

function ccMimeTypes($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

function instapageAddScriptVersion($tag) {
  if ((!is_admin()) && (!isLoginPage())) {
    $hash = get_field('asset_hash', 'option');
    $excludedPattern = '/plugins\/akismet/';

    if (
      $hash &&
      strpos($tag, site_url()) !== false &&
      preg_match($excludedPattern, $tag) === 0
    ) {
      $hash = 'instapageasset.'. $hash;
      $pattern = '/\.(css|js)/';
      return  preg_replace($pattern, '.' . $hash . '.$1', $tag);
    }
  }

  return $tag;
}

function addCustomAdminJs() {
  wp_enqueue_script('instapage_custom_admin_js', get_template_directory_uri() . '/v5/assets/js/v51/src/admin.js', ['jquery']);
}

function filterAuthorEditDropdown($queryArgs) {
  $queryArgs['who'] = '';

  return $queryArgs;
}

function instapageUserRegister( $userID ) {
  if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
    update_user_meta($userID, 'nickname', $_POST['first_name'] . ' ' . $_POST['last_name']);
  }
}

function modifyNoCacheHeaders($headers) {
  $is_preview = isset($_GET['preview']) ? $_GET['preview'] : false;

  if (!is_admin() && !$is_preview && !is_user_logged_in()) {
    if (isset($headers['Expires'])) {
      //Remove default WP Expires header that prevents caching.
      unset($headers['Expires']);
    }
  } else {
    setcookie('no-cache', 'true');

    //Those settings may be overwritten by .htaccess file
    $headers['Expires'] = 'Wed, 11 Jan 1984 05:00:00 GMT';
    $headers['Cache-Control'] = (is_admin() ? 'private, ' : '') . 'no-cache, no-store, must-revalidate, max-age=0';
  }

  return $headers;
}

function removeAdminBar() {
  if (!is_admin()) {
    show_admin_bar(false);
  }
}

/**
 * Removes `<` and `>` from password reset email which caused link to not be rendered
 */
function instapagePasswordResetMessage($message, $key, $userLogin, $userData) {
  return preg_replace('#\<([^\>]+)\>#', '$1', $message);
}

/**
 * Search by default searches only in blog
 */
function instapageSearchQuery($query) {
  if (!is_admin() && $query->is_main_query() && $query->is_search() && empty($_REQUEST['post_type'])) {
    $query->set('post_type', 'post');
  }
  return $query;
}

/**
 * Creates required database structure, if needed
 */
function instapageInitNonce() {
  \Instapage\Classes\SimpleNonce::init();
}

/**
 * Adds nonce field to /wp-login.php form
 */
function instapageLoginFormNonce() {
  \Instapage\Helpers\HtmlHelper::createNonceField('login-form');
}

/**
 * Validates nonce field in /wp-login.php form
 */
function instapageLoginFormNonceValidation($user, $password) {
  $nonceName = 'login-form';

  if (!\Instapage\Classes\SimpleNonce::checkNonce(getVar($_POST[$nonceName]), getVar($_POST[$_POST[$nonceName]]))) {
    return new WP_Error('denied', __('<strong>ERROR</strong>: Invalid token.'));
  }

  return $user;
}

// init ajax endpoints
add_action('admin_init', function() {
  // init Simple Nonce Ajax endpoint
  \Instapage\Classes\SimpleNonceAjax::init();
  // init Load More Content Ajax expoint
  \Instapage\Classes\LoadMoreContentAjax::init();
});

// All insta custom ACF fields entry points
add_filter(
  'acf/load_field/name=insta_custom_choose_post_type',
   ['Instapage\Classes\AdvancedCustomFieldsTweaks', 'registerACFWithPostTypesList']
);

// All post content stages
add_filter(
  'acf/load_field/name=cp_content_stage',
   ['Instapage\Classes\AdvancedCustomFieldsTweaks', 'registerAvailableContentStages']
);

// All post topics
add_filter(
  'acf/load_field/name=cp_topic',
   ['Instapage\Classes\AdvancedCustomFieldsTweaks', 'registerAvailableTopics']
);

// All products (post custom field)
add_filter(
  'acf/load_field/name=cp_product',
   ['Instapage\Classes\AdvancedCustomFieldsTweaks', 'registerAvailableProducts']
);

// All ConvertPro CTAs
add_filter(
  'acf/load_field/name=cp_id',
   ['Instapage\Classes\AdvancedCustomFieldsTweaks', 'registerAvailableConvertProCta']
);

// why it is called in aciton not just here in functions?
// I'll tell you why. Because at moment of loading functions.php there is no
// our lovely instapage class loader, so we cannot use class before including file containing RssFeedEnhancer
// You can put more lines of code here
add_action('wp_loaded', function () {
  \Instapage\Classes\RssFeedEnhancer::getInstance()->enhance();
  \Instapage\Classes\DashboardEnhancer::getInstance()->enhance();
  \Instapage\Classes\ComponentCache::hookClearingCache();
  (new \Instapage\Modules\ColorParameterizer\ColorParameterizer())->run();
});

new \Instapage\Classes\ConvertPro\CtaInjector();
