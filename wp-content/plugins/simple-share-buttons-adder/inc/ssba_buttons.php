<?php
defined('ABSPATH') or die('No direct access permitted');

// format the returned number
function instapageFormatShareCounter( $value )
{
	$value = intval( $value );

	switch( true )
	{
		case ( $value < 999 ):

			return '' . $value;
			break;

		case ( $value < 9999 ):

			$value = round( $value, -2 );
			$value = ( ( float ) $value / ( float ) 1000 ) . __( 'K' );

			return $value;
			break;

		default:

			$value = round( $value, -3 );
			$value = ( ( float ) $value / ( float ) 1000 ) . __( 'K' );

			return $value;
	}
}

// add share buttons to content and/or excerpts
add_filter('the_content', 'show_share_buttons', (int) $arrSettings['ssba_content_priority']);

function getShareCounter( $share_name, $current_url, $arrSettings, $format = true )
{
	$post_id = isset( $arrSettings[ 'post_id' ] ) ? $arrSettings[ 'post_id' ] : null;
	$query_vars = array();
	parse_str( parse_url( $current_url, PHP_URL_QUERY ), $query_vars );

	if( !$post_id || ( isset( $query_vars[ 'preview' ] ) && $query_vars[ 'preview' ] ) )
	{
		return 0;
	}

	$update_cache = false;
	$share_count_cache = get_post_meta( $post_id, $share_name . '_share_count_cache', true );
	$init_share_count = isset( $share_count_cache->counter ) ? $share_count_cache->counter : null;
	$use_cache = ( isset( $arrSettings[ 'ssba_share_count_cache' ] ) && $arrSettings[ 'ssba_share_count_cache' ] == 'Y' ) ? true : false;
	$cache_invalidation_time = isset( $arrSettings[ 'ssba_share_count_cache_time' ] ) ? intval( $arrSettings[ 'ssba_share_count_cache_time' ] ) : 0;
	$cache_expires = isset( $share_count_cache->time ) ? $share_count_cache->time + $cache_invalidation_time : null;

	if( $use_cache && ( empty( $cache_expires ) || $cache_expires <= time() ) )
	{
	 	$update_cache = true;
	}

	if( $update_cache || $init_share_count === null )
	{

		switch( $share_name )
		{
				case 'facebook':
					$share_count = getFacebookShareCount( $current_url, false );
				break;
				case 'twitter':
					$share_count = ssba_twitter_count( $current_url, false );
				break;
				case 'buffer':
					$share_count = getBufferShareCount( $current_url, false );
				break;
				case 'linkedin':
					$share_count = getLinkedinShareCount( $current_url, false );
				break;
				default:
					$share_count = null;
		}

		$init_share_count = isset( $share_count ) ? $share_count : $init_share_count;

		if( $use_cache && $update_cache && !is_null( $init_share_count ) )
		{
			$share_count_cache = new stdClass;
			$share_count_cache->counter = ( $init_share_count === null ) ? 0 : $init_share_count;
			$share_count_cache->time = time();
			update_post_meta( $post_id, $share_name . '_share_count_cache',	$share_count_cache );
		}
	}

	$init_share_count = is_null( $init_share_count ) ? 0 : $init_share_count;

	if( $format )
	{
		return instapageFormatShareCounter( $init_share_count );
	}
	else
	{
		return $init_share_count;
	}
}

function getShareButtonsData( $data = null, $get_counters = false )
{
	 $arr_settings = get_ssba_settings();

	 if( !empty( $arr_settings[ 'ssba_selected_buttons' ] ) )
	 {
		global $post;
		$post_id = ( isset( $data[ 'post_id' ] ) ) ? $data[ 'post_id' ] : $post->ID;
		$arr_settings[ 'post_id' ] = $post_id;
		$current_url = ( isset( $data[ 'page_url' ] ) ) ? urlencode($data[ 'page_url' ]) : ssba_current_url( null );
		$page_title = ( isset( $data[ 'page_title' ] ) ) ? $data[ 'page_title' ] : esc_attr( strip_tags( get_the_title( $post_id ) ) );
		$buttons = explode( ',', $arr_settings[ 'ssba_selected_buttons' ] );
		$share_widged_object = new stdClass;
		$share_widged_object->buttons_array = array();
		$share_widged_object->total_shares_counter = 0;

		foreach( $buttons as $button )
		{
			$share_object = new stdClass;
			$share_object->name = $button;
			$share_object->class = 'ssba_' . $button . '_share';

			switch( $button )
			{
				case 'facebook':
					$share_object->share_count = ( $get_counters ) ? getShareCounter( $button, $current_url, $arr_settings, false ) : 0;
					$share_object->share_link = 'http://www.facebook.com/sharer.php?u=' . $current_url;
					$share_object->icon = 'fa-facebook';
				break;
				case 'twitter':
					$share_object->share_text = urlencode( html_entity_decode( $page_title . ' ' . $arr_settings[ 'ssba_twitter_text' ], ENT_COMPAT, 'UTF-8' ) );
					$share_object->share_count = ( $get_counters ) ? getShareCounter( $button, $current_url, $arr_settings, false ) : 0;
					$share_object->share_link = 'http://twitter.com/share?url=' . $current_url . '&amp;text=' . $share_object->share_text;
					$share_object->icon = 'fa-twitter';
				break;
				case 'linkedin':
					$share_object->share_count = ( $get_counters ) ? getShareCounter( $button, $current_url, $arr_settings, false ) : 0;
					$share_object->share_link = 'http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $current_url;
					$share_object->icon = 'fa-linkedin';
				break;
				case 'buffer':
					$share_object->share_count = ( $get_counters ) ? getShareCounter( $button, $current_url, $arr_settings, false ) : 0;
					$share_object->share_link = 'https://bufferapp.com/add?url=' . $current_url . '&amp;text=' . ( $arr_settings[ 'ssba_buffer_text' ] != '' ? $arr_settings[ 'ssba_buffer_text' ] : NULL) . ' ' . $page_title;
					$share_object->icon = null;
				break;
				case 'email':
					$share_object->share_count = ( $get_counters ) ? intval( get_post_meta( $post_id, 'instapage.email_share_counter', true ) ) : 0;
					$share_object->share_link = null;
					$share_object->icon = 'fa-envelope-o';
				break;
				default:
					$share_object->share_count = 0;
					$share_object->share_link = null;
				break;
			}

			$share_widged_object->total_shares_counter += $share_object->share_count;
			$share_widged_object->buttons_array[ $button ] = $share_object;
		}

		$share_widged_object->total_shares_class = ( $share_widged_object->total_shares_counter > 999 ) ? 'large-value' : '';
	}

	return $share_widged_object;
}

// get and show share buttons
function show_share_buttons($content, $booShortCode = FALSE, $atts = '') {

	// globals
	global $post;

	// variables
	$htmlContent = $content;
	$pattern = get_shortcode_regex();

	// ssba_hide shortcode is in the post content and instance is not called by shortcode ssba
	if (isset($post->post_content) && preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
		&& array_key_exists( 2, $matches )
		&& in_array('ssba_hide', $matches[2])
		&& $booShortCode == FALSE) {

		// exit the function returning the content without the buttons
		return $content;
	}

	// get sbba settings
	$arrSettings = get_ssba_settings();

	// placement on pages/posts/categories/archives/homepage
	if ((!is_home() && !is_front_page() && is_page() && $arrSettings['ssba_pages'] == 'Y') || (is_single() && $arrSettings['ssba_posts'] == 'Y') || (is_category() && $arrSettings['ssba_cats_archs'] == 'Y') || (is_archive() && $arrSettings['ssba_cats_archs'] == 'Y') || ( (is_home() || is_front_page() ) && $arrSettings['ssba_homepage'] == 'Y') || $booShortCode == TRUE) {


		// if not shortcode
		if (isset($atts['widget']) && $atts['widget'] == 'Y')
			// use widget share text
			$strShareText = $arrSettings['ssba_widget_text'];
		else
			// use normal share text
			$strShareText = $arrSettings['ssba_share_text'];

		// post id
		$intPostID = get_the_ID();

		// ssba div
		$htmlShareButtons = '<!-- Simple Share Buttons Adder ('.SSBA_VERSION.') simplesharebuttons.com --><div class="ssba ssba-wrap">';

		// center if set so
		$htmlShareButtons.= '<div style="text-align:'.$arrSettings['ssba_align'].'">';

		// add custom text if set and set to placement above or left
		if (($strShareText != '') && ($arrSettings['ssba_text_placement'] == 'above' || $arrSettings['ssba_text_placement'] == 'left')) {

			// check if user has left share link box checked
			if ($arrSettings['ssba_link_to_ssb'] == 'Y') {

				// share text with link
				$htmlShareButtons .= '<a href="https://simplesharebuttons.com" target="_blank">' . $strShareText . '</a>';
			}

			// just display the share text
			else {

				// share text
				$htmlShareButtons .= $strShareText;
			}
			// add a line break if set to above
			($arrSettings['ssba_text_placement'] == 'above' ? $htmlShareButtons .= '<br/>' : NULL);
		}

		// if running standard
		if ($booShortCode == FALSE) {

			// use wordpress functions for page/post details
			$urlCurrentPage = get_permalink($post->ID);
			$strPageTitle = get_the_title($post->ID);

		} else { // using shortcode

			// set page URL and title as set by user or get if needed
			$urlCurrentPage = (isset($atts['url']) ? $atts['url'] : ssba_current_url($atts));
			$strPageTitle = (isset($atts['title']) ? $atts['title'] : get_the_title());
		}

		// strip any unwanted tags from the page title
		$strPageTitle = esc_attr(strip_tags($strPageTitle));

		// the buttons!
		$htmlShareButtons.= get_share_buttons($arrSettings, $urlCurrentPage, $strPageTitle, $intPostID);

		// add custom text if set and set to placement right or below
		if (($strShareText != '') && ($arrSettings['ssba_text_placement'] == 'right' || $arrSettings['ssba_text_placement'] =='below')) {

			// add a line break if set to above
			($arrSettings['ssba_text_placement'] == 'below' ? $htmlShareButtons .= '<br/>' : NULL);

			// check if user has checked share link option
			if ($arrSettings['ssba_link_to_ssb'] == 'Y') {

				// share text with link
				$htmlShareButtons .= '<a href="https://simplesharebuttons.com" target="_blank">' . $strShareText . '</a>';
			}

			// just display the share text
			else {

				// share text
				$htmlShareButtons .= $strShareText;
			}
		}

		// close center if set
		$htmlShareButtons.= '</div>';
		$htmlShareButtons.= '</div>';

		// if not using shortcode
		if ($booShortCode == FALSE) {

			// switch for placement of ssba
			switch ($arrSettings['ssba_before_or_after']) {

			case 'before': // before the content
				$htmlContent = $htmlShareButtons . $content;
				break;

			case 'after': // after the content
				$htmlContent = $content . $htmlShareButtons;
				break;

			case 'both': // before and after the content
				$htmlContent = $htmlShareButtons . $content . $htmlShareButtons;
				break;
			}
		}

		// if using shortcode
		else {

			// just return buttons
			$htmlContent = $htmlShareButtons;
		}
	}

	// return content and share buttons
	return $htmlContent;
}

// if we wish to add to excerpts
if(isset($arrSettings['ssba_excerpts']) && $arrSettings['ssba_excerpts'] == 'Y') {

	// add a hook
	add_filter( 'the_excerpt', 'show_share_buttons');
}

// shortcode for adding buttons
function ssba_buttons($atts) {

	// get buttons - NULL for $content, TRUE for shortcode flag
	$htmlShareButtons = show_share_buttons(NULL, TRUE, $atts);

	//return buttons
	return $htmlShareButtons;
}

// shortcode for hiding buttons
function ssba_hide($content) {
	// no need to do anything here!
}

// get URL function
function ssba_current_url($atts) {
	// if multisite has been set to true
	if (isset($atts['multisite'])) {
		global $wp;
		$url = add_query_arg($_SERVER['QUERY_STRING'], '', home_url($wp->request));
		return esc_url($url);
	}

	// add http
	$urlCurrentPage = 'http';

	// add s to http if required
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
		$urlCurrentPage .= "s";
	}

	// add colon and forward slashes
	$urlCurrentPage .= "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

	// return url
	return esc_url($urlCurrentPage);
}

// get set share buttons
function get_share_buttons($arrSettings, $urlCurrentPage, $strPageTitle, $intPostID) {

	// variables
	$htmlShareButtons = '';

	// explode saved include list and add to a new array
	$arrSelectedSSBA = explode(',', $arrSettings['ssba_selected_buttons']);

	// check if array is not empty
	if ($arrSettings['ssba_selected_buttons'] != '') {

		// add post ID to settings array
		$arrSettings['post_id'] = $intPostID;

		// if show counters option is selected
		if ($arrSettings['ssba_show_share_count'] == 'Y') {

			// set show flag to true
			$booShowShareCount = true;

			// if show counters once option is selected
			if ($arrSettings['ssba_share_count_once'] == 'Y') {

				// if not a page or post
				if (!is_page() && !is_single()) {

					// set show flag to false
					$booShowShareCount = false;
				}
			}
		} else {
			// set show flag to false
			$booShowShareCount = false;
		}

		// for each included button
		foreach ($arrSelectedSSBA as $strSelected) {

			$strGetButton = 'ssba_' . $strSelected;

			// add a list item for each selected option
			$htmlShareButtons .= $strGetButton($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount);
		}
	}

	// return share buttons
	return $htmlShareButtons;
}

// get facebook button
function ssba_facebook($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// facebook share link
	$htmlShareButtons = '<a data-site="" class="ssba_facebook_share" href="http://www.facebook.com/sharer.php?u=' . $urlCurrentPage  . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow"' : NULL) .'>';

	// if not using custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show selected ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/facebook.png" title="Facebook" class="ssba ssba-img" alt="Share on Facebook" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_facebook'] . '" title="Facebook" class="ssba ssba-img" alt="Share on Facebook" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// if show share count is set to Y
	if ($arrSettings['ssba_show_share_count'] == 'Y' && $booShowShareCount == true) {
		// get and add facebook share count
		$htmlShareButtons .= '<span class="ssba_sharecount">' . getFacebookShareCount($urlCurrentPage, $arrSettings) . '</span>';
	}

	// return share buttons
	return $htmlShareButtons;
}

// get facebook share count
function getFacebookShareCount( $urlCurrentPage, $format = true )
{
  $facebook_share_count = null;
	$html_facebook_share_details = wp_remote_get( 'http://graph.facebook.com/' . $urlCurrentPage, array( 'timeout' => 6 ) );

	if ( is_wp_error( $html_facebook_share_details ) )
	{
		return null;
	}

	$arr_facebook_share_details = json_decode( $html_facebook_share_details[ 'body' ], true );

  if ( isset( $arr_facebook_share_details[ 'share' ] ) && isset( $arr_facebook_share_details[ 'share' ][ 'share_count' ] ) )
  {
    $facebook_share_count = $arr_facebook_share_details[ 'share' ][ 'share_count' ];
  }

	if( is_null( $facebook_share_count ) )
	{
		return null;
	}

	if( $format )
	{
		return instapageFormatShareCounter( $facebook_share_count );
	}
	else
	{
		return $facebook_share_count;
	}
}

// get twitter button
function ssba_twitter($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// format the URL into friendly code
	$twitterShareText = urlencode(html_entity_decode($strPageTitle . ' ' . $arrSettings['ssba_twitter_text'], ENT_COMPAT, 'UTF-8'));

	// twitter share link
	$htmlShareButtons = '<a data-site="" class="ssba_twitter_share" href="http://twitter.com/share?url=' . $urlCurrentPage . '&amp;text=' . $twitterShareText . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow"' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/twitter.png" title="Twitter" class="ssba ssba-img" alt="Tweet about this on Twitter" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_twitter'] . '" title="Twitter" class="ssba ssba-img" alt="Tweet about this on Twitter" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// if show share count is set to Y
	if ($arrSettings['ssba_show_share_count'] == 'Y' && $booShowShareCount == true) {
		// newsharedcount needs to be enabled
		if ($arrSettings['twitter_newsharecounts'] == 'Y') {
			$htmlShareButtons .= '<span class="ssba_sharecount">' . ssba_twitter_count($urlCurrentPage) . '</span>';
		}
	}

	// return share buttons
	return $htmlShareButtons;
}

// get twitter share count
function ssba_twitter_count( $urlCurrentPage, $format = true )
{
	//TODO - use twitter API to get number of shares
	return 0;
}

// get google+ button
function ssba_google($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// google share link
	$htmlShareButtons = '<a data-site="" class="ssba_google_share" href="https://plus.google.com/share?url=' . $urlCurrentPage  . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/google.png" title="Google+" class="ssba ssba-img" alt="Share on Google+" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_google'] . '" title="Share on Google+" class="ssba ssba-img" alt="Google+" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// if show share count is set to Y
	if ($arrSettings['ssba_show_share_count'] == 'Y' && $booShowShareCount == true) {

		$htmlShareButtons .= '<span class="ssba_sharecount">' . getGoogleShareCount($urlCurrentPage) . '</span>';
	}

	// return share buttons
	return $htmlShareButtons;
}

// get google share count
function getGoogleShareCount( $urlCurrentPage, $format = true )
{

	$args = array(
		'method' => 'POST',
		'headers' => array(
			// setup content type to JSON
			'Content-Type' => 'application/json'
		),
		// setup POST options to Google API
		'body' => json_encode(array(
				'method' => 'pos.plusones.get',
				'id' => 'p',
				'method' => 'pos.plusones.get',
				'jsonrpc' => '2.0',
				'key' => 'p',
				'apiVersion' => 'v1',
				'params' => array(
					'nolog'=>true,
					'id'=> $urlCurrentPage,
					'source'=>'widget',
					'userId'=>'@viewer',
					'groupId'=>'@self'
				)
			)),
		// disable checking SSL sertificates
		'sslverify'=>false
	);

	// retrieves JSON with HTTP POST method for current URL
	$json_string = wp_remote_post("https://clients6.google.com/rpc", $args);

	if (is_wp_error($json_string)){
		return null;
	} else {
		$json = json_decode($json_string['body'], true);
		$count = isset( $json[ 'result' ][ 'metadata' ][ 'globalCounts' ][ 'count' ] ) ? intval( $json[ 'result' ][ 'metadata' ][ 'globalCounts' ][ 'count' ] ) : null;

		if( is_null( $count ) )
		{
			return null;
		}

		if( $format )
		{
			return instapageFormatShareCounter( $count );
		}
		else
		{
			return $count;
		}
	}
}

// get diggit button
function ssba_diggit($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// diggit share link
	$htmlShareButtons = '<a data-site="digg" class="ssba_diggit_share ssba_share_link" href="http://www.digg.com/submit?url=' . $urlCurrentPage  . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/diggit.png" title="Digg" class="ssba ssba-img" alt="Digg this" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_diggit'] . '" title="Digg" class="ssba ssba-img" alt="Digg this" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// return share buttons
	return $htmlShareButtons;
}

// get reddit button
function ssba_reddit($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// reddit share link
	$htmlShareButtons = '<a data-site="reddit" class="ssba_reddit_share" href="http://reddit.com/submit?url=' . $urlCurrentPage  . '&amp;title=' . $strPageTitle . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/reddit.png" title="Reddit" class="ssba ssba-img" alt="Share on Reddit" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_reddit'] . '" title="Reddit" class="ssba ssba-img" alt="Share on Reddit" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// if show share count is set to Y
	if ($arrSettings['ssba_show_share_count'] == 'Y' && $booShowShareCount == true) {

		// get and display share count
		$htmlShareButtons .= '<span class="ssba_sharecount">' . getRedditShareCount($urlCurrentPage) . '</span>';
	}

	// return share buttons
	return $htmlShareButtons;
}

// get reddit share count
function getRedditShareCount($urlCurrentPage) {
	// get results from reddit and return the number of shares
	$htmlRedditShareDetails = wp_remote_get('http://www.reddit.com/api/info.json?url='.$urlCurrentPage, array('timeout' => 6));

	// check there was an error
	if (is_wp_error($htmlRedditShareDetails)) {
		return 0;
	}

	// decode and get share count
	$arrRedditResult = json_decode($htmlRedditShareDetails['body'], true);
	$intRedditShareCount = (isset($arrRedditResult['data']['children']['0']['data']['score']) ? $arrRedditResult['data']['children']['0']['data']['score'] : 0);
	return ( $intRedditShareCount ) ? instapageFormatShareCounter( $intRedditShareCount ) : '0';
}

// get linkedin button
function ssba_linkedin($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// linkedin share link
	$htmlShareButtons = '<a data-site="linkedin" class="ssba_linkedin_share ssba_share_link" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $urlCurrentPage  . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/linkedin.png" title="LinkedIn" class="ssba ssba-img" alt="Share on LinkedIn" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_linkedin'] . '" alt="Share on LinkedIn" title="LinkedIn" class="ssba ssba-img" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// if show share count is set to Y
	if ($arrSettings['ssba_show_share_count'] == 'Y' && $booShowShareCount == true) {

		// get and display share count
		$htmlShareButtons .= '<span class="ssba_sharecount">' . getLinkedinShareCount($urlCurrentPage) . '</span>';
	}

	// return share buttons
	return $htmlShareButtons;
}

// get linkedin share count
function getLinkedinShareCount( $urlCurrentPage, $format = true )
{
	// get results from linkedin and return the number of shares
	$htmlLinkedinShareDetails = wp_remote_get('http://www.linkedin.com/countserv/count/share?url='.$urlCurrentPage, array('timeout' => 6));

	 // if there was an error
	if (is_wp_error($htmlLinkedinShareDetails))
	{
		return null;
	}

	// extract/decode share count
	$htmlLinkedinShareDetails = str_replace('IN.Tags.Share.handleCount(', '', $htmlLinkedinShareDetails);
	$htmlLinkedinShareDetails = str_replace(');', '', $htmlLinkedinShareDetails);
	$arrLinkedinShareDetails = json_decode($htmlLinkedinShareDetails['body'], true);
	$intLinkedinShareCount = isset( $arrLinkedinShareDetails['count'] ) ? $arrLinkedinShareDetails['count'] : null;;

	if( is_null( $intLinkedinShareCount ) )
	{
		return null;
	}

	if( $format )
	{
		return instapageFormatShareCounter( $intLinkedinShareCount );
	}
	else
	{
		return $intLinkedinShareCount;
	}
}

// get pinterest button
function ssba_pinterest($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// if using featured images for Pinteres
	if($arrSettings['ssba_pinterest_featured'] == 'Y')
	{
		// if this post has a featured image
		if(has_post_thumbnail($arrSettings['post_id']))
		{
			// get the featured image
			$urlPostThumb = wp_get_attachment_image_src(get_post_thumbnail_id($arrSettings['post_id']), 'full');
			$urlPostThumb = $urlPostThumb[0];
		}
		// no featured image set
		else
		{
			// use the pinterest default
			$urlPostThumb = $arrSettings['ssba_default_pinterest'];
		}

		// pinterest share link
		$htmlShareButtons = '<a data-site="pinterest-featured" href="http://pinterest.com/pin/create/bookmarklet/?is_video=false&url='.$urlCurrentPage.'&media='.$urlPostThumb.'&description='.$strPageTitle.'" class="ssba_pinterest_share ssba_share_link" '.($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL).'>';
	}
	// not using featured images for pinterest
	else
	{
		// use the choice of pinnable images approach
		$htmlShareButtons = "<a data-site='pinterest' class='ssba_pinterest_share' href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;//assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());'>";
	}

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/pinterest.png" title="Pinterest" class="ssba ssba-img" alt="Pin on Pinterest" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img title="Pinterest" class="ssba ssba-img" src="' . $arrSettings['ssba_custom_pinterest'] . '" alt="Pin on Pinterest" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// if show share count is set to Y
	if ($arrSettings['ssba_show_share_count'] == 'Y' && $booShowShareCount == true) {

		$htmlShareButtons .= '<span class="ssba_sharecount">' . getPinterestShareCount($urlCurrentPage) . '</span>';
	}

	// return share buttons
	return $htmlShareButtons;
}

// get pinterest share count
function getPinterestShareCount($urlCurrentPage) {

	 // get results from pinterest
	$htmlPinterestShareDetails = wp_remote_get('http://api.pinterest.com/v1/urls/count.json?url='.$urlCurrentPage, array('timeout' => 6));

	// check there was an error
	if (is_wp_error($htmlPinterestShareDetails)) {
		return 0;
	}

	// decode data
	$htmlPinterestShareDetails = str_replace('receiveCount(', '', $htmlPinterestShareDetails);
	$htmlPinterestShareDetails = str_replace(')', '', $htmlPinterestShareDetails);
	$arrPinterestShareDetails = json_decode($htmlPinterestShareDetails['body'], true);
	$intPinterestShareCount = $arrPinterestShareDetails['count'];
	return ( $intPinterestShareCount ) ? instapageFormatShareCounter( $intPinterestShareCount ) : '0';
}

// get stumbleupon button
function ssba_stumbleupon($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// stumbleupon share link
	$htmlShareButtons = '<a data-site="stumbleupon" class="ssba_stumbleupon_share ssba_share_link" href="http://www.stumbleupon.com/submit?url=' . $urlCurrentPage  . '&amp;title=' . $strPageTitle . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/stumbleupon.png" title="StumbleUpon" class="ssba ssba-img" alt="Share on StumbleUpon" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_stumbleupon'] . '" alt="Share on StumbleUpon" title="StumbleUpon" class="ssba ssba-img" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// if show share count is set to Y
	if ($arrSettings['ssba_show_share_count'] == 'Y' && $booShowShareCount == true) {

		$htmlShareButtons .= '<span class="ssba_sharecount">' . getStumbleUponShareCount($urlCurrentPage) . '</span>';
	}

	// return share buttons
	return $htmlShareButtons;
}

// get stumbleupon share count
function getStumbleUponShareCount($urlCurrentPage) {

	// get results from stumbleupon and return the number of shares
	$htmlStumbleUponShareDetails = wp_remote_get('http://www.stumbleupon.com/services/1.01/badge.getinfo?url='.$urlCurrentPage, array('timeout' => 6));

	// check there was an error
	if (is_wp_error($htmlStumbleUponShareDetails)) {
		return 0;
	}

	// decode data
	$arrStumbleUponResult = json_decode($htmlStumbleUponShareDetails['body'], true);
	$intStumbleUponShareCount = (isset($arrStumbleUponResult['result']['views']) ? $arrStumbleUponResult['result']['views'] : 0);
	return ( $intStumbleUponShareCount ) ? instapageFormatShareCounter( $intStumbleUponShareCount ) : '0';
}

// get email button
function ssba_email($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// replace ampersands as needed for email link
	$emailTitle = str_replace('&', '%26', $strPageTitle);

	// email share link
	$htmlShareButtons = '<a data-site="email" class="ssba_email_share" href="mailto:?subject=' . $emailTitle . '&amp;body=' . $arrSettings['ssba_email_message'] . '%20' . $urlCurrentPage  . '">';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/email.png" title="Email" class="ssba ssba-img" alt="Email this to someone" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_email'] . '" title="Email" class="ssba ssba-img" alt="Email to someone" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// return share buttons
	return $htmlShareButtons;
}

// get flattr button
function ssba_flattr($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// check for dedicated flattr URL
	if ($arrSettings['ssba_flattr_url'] != '') {

		// updatae url that will be set to specified URL
		$urlCurrentPage = $arrSettings['ssba_flattr_url'];
	}

	// flattr share link
	$htmlShareButtons = '<a data-site="flattr" class="ssba_flattr_share" href="https://flattr.com/submit/auto?user_id=' . $arrSettings['ssba_flattr_user_id'] . '&amp;title=' . $strPageTitle . '&amp;url=' . $urlCurrentPage . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/flattr.png" title="Flattr" class="ssba ssba-img" alt="Flattr the author" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_flattr'] . '" title="Flattr" class="ssba ssba-img" alt="Flattr the author" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// return share buttons
	return $htmlShareButtons;
}

// get buffer button
function ssba_buffer($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// buffer share link
	$htmlShareButtons = '<a  data-site="buffer" class="ssba_buffer_share" href="https://bufferapp.com/add?url=' . $urlCurrentPage . '&amp;text=' . ( $arrSettings[ 'ssba_buffer_text' ] != '' ? $arrSettings[ 'ssba_buffer_text' ] : NULL) . ' ' . urlencode( $strPageTitle ) . '" ' . ( $arrSettings[ 'ssba_share_new_window' ] == 'Y' ? ' target="_blank" ' : NULL ) . ( $arrSettings[ 'ssba_rel_nofollow' ] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';
	// if image set is not custom
	if ( $arrSettings[ 'ssba_image_set' ] != 'custom' )
	{
		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/buffer.png" title="Buffer" class="ssba ssba-img" alt="Buffer this page" />';
	}
	// if using custom images
	else
	{
		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings[ 'ssba_custom_buffer' ] . '" title="Buffer" class="ssba ssba-img" alt="Buffer this page" />';
	}

	$htmlShareButtons .= '</a>';

	if ( $arrSettings[ 'ssba_show_share_count' ] == 'Y' && $booShowShareCount == true )
	{
		$htmlShareButtons .= '<span class="ssba_sharecount">' . getBufferShareCount( $urlCurrentPage ) . '</span>';
	}

	return $htmlShareButtons;
}

function getBufferShareCount( $url, $format = true )
{
	if( !isUrlEncoded( $url ) )
	{
		$url = urlencode( $url );
	}

	$result = wp_remote_get( 'https://api.bufferapp.com/1/links/shares.json?url=' . $url, array( 'timeout' => 6 ) );

	if( is_wp_error( $result ) )
	{
		return null;
	}

	$array = json_decode( $result[ 'body' ], true );
	$count = ( isset( $array[ 'shares' ] ) ? $array[ 'shares' ] : null );

	if( is_null( $count ) )
	{
		return null;
	}

	if( $format )
	{
		return instapageFormatShareCounter( $count );
	}
	else
	{
		return $count;
	}
}

// get tumblr button
function ssba_tumblr($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {
	// tumblr share link
	$htmlShareButtons = '<a data-site="tumblr" class="ssba_tumblr_share" href="http://www.tumblr.com/share/link?url=' . $urlCurrentPage . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/tumblr.png" title="tumblr" class="ssba ssba-img" alt="Share on Tumblr" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_tumblr'] . '" title="tumblr" class="ssba ssba-img" alt="share on Tumblr" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// if show share count is set to Y
	if ($arrSettings['ssba_show_share_count'] == 'Y' && $booShowShareCount == true) {

		$htmlShareButtons .= '<span class="ssba_sharecount">' . getTumblrShareCount($urlCurrentPage) . '</span>';
	}

	// return share buttons
	return $htmlShareButtons;
}

// get tumblr share count
function getTumblrShareCount($urlCurrentPage)
{
	// get results from tumblr and return the number of shares
	$result = wp_remote_get('http://api.tumblr.com/v2/share/stats?url=' . $urlCurrentPage, array('timeout' => 6));

	// check there was an error
	if (is_wp_error($result)) {
		// return
		return 0;
	}

	// decode data
	$array = json_decode($result['body'], true);
	$count = (isset($array['response']['note_count']) ? $array['response']['note_count'] : 0);

	// return
	return ($count) ? $count : '0';
}

// get print button
function ssba_print($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// linkedin share link
	$htmlShareButtons = '<a data-site="print" class="ssba_print ssba_share_link" href="#" onclick="window.print()">';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/print.png" title="Print" class="ssba ssba-img" alt="Print this page" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_print'] . '" title="Print" class="ssba ssba-img" alt="Print this page" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// return share buttons
	return $htmlShareButtons;
}

// get vk button
function ssba_vk($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// vk share link
	$htmlShareButtons = '<a data-site="vk" class="ssba_vk_share ssba_share_link" href="http://vkontakte.ru/share.php?url=' . $urlCurrentPage  . '" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/vk.png" title="VK" class="ssba ssba-img" alt="Share on VK" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_vk'] . '" title="VK" class="ssba ssba-img" alt="Share on VK" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// return share buttons
	return $htmlShareButtons;
}

// get yummly button
function ssba_yummly($arrSettings, $urlCurrentPage, $strPageTitle, $booShowShareCount) {

	// yummly share link
	$htmlShareButtons = '<a data-site="yummly" class="ssba_yummly_share ssba_share_link" href="http://www.yummly.com/urb/verify?url=' . $urlCurrentPage  . '&title='.urlencode(html_entity_decode($strPageTitle)).'" ' . ($arrSettings['ssba_share_new_window'] == 'Y' ? ' target="_blank" ' : NULL) . ($arrSettings['ssba_rel_nofollow'] == 'Y' ? ' rel="nofollow" ' : NULL) . '>';

	// if image set is not custom
	if ($arrSettings['ssba_image_set'] != 'custom') {

		// show ssba image
		$htmlShareButtons .= '<img src="' . plugins_url() . '/simple-share-buttons-adder/buttons/' . $arrSettings['ssba_image_set'] . '/yummly.png" title="Yummly" class="ssba ssba-img" alt="Share on Yummly" />';
	}

	// if using custom images
	else {

		// show custom image
		$htmlShareButtons .= '<img src="' . $arrSettings['ssba_custom_yummly'] . '" title="Yummly" class="ssba ssba-img" alt="Share on Yummly" />';
	}

	// close href
	$htmlShareButtons .= '</a>';

	// if show share count is set to Y
	if ($arrSettings['ssba_show_share_count'] == 'Y' && $booShowShareCount == true) {

		$htmlShareButtons .= '<span class="ssba_sharecount">' . getYummlyShareCount($urlCurrentPage) . '</span>';
	}

	// return share buttons
	return $htmlShareButtons;
}

// get yummly share count
function getYummlyShareCount($urlCurrentPage)
{
	// get results from yummly and return the number of shares
	$result = wp_remote_get('http://www.yummly.com/services/yum-count?url=' . $urlCurrentPage, array('timeout' => 6));

	// check there was an error
	if (is_wp_error($result)) {
		// return
		return 0;
	}

	// decode data
	$array = json_decode($result['body'], true);
	$count = (isset($array['count']) ? $array['count'] : 0);

	// return
	return ($count) ? $count : '0';
}

function isUrlEncoded( $data )
{
	if ( urlencode( urldecode( $data ) ) === $data )
	{
		return true;
	}
	else
	{
		return false;
	}
}

// register shortcode [ssba] to show [ssba_hide]
add_shortcode( 'ssba', 'ssba_buttons' );
add_shortcode( 'ssba_hide', 'ssba_hide' );
