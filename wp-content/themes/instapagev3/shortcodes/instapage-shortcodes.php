<?php

add_action( 'init', 'instapageEditorButtons' );
add_filter( 'the_content', 'instapagePreShortcodeContentFilter', 1, 1 );
add_filter( 'no_texturize_shortcodes', 'shortcodesToExemptFromWptexturize', 1 );
add_shortcode( 'chapter_listing', 'seoPageChapterListing' );
add_shortcode( 'special_info', 'specialInformation' );
add_shortcode( 'steps', 'instapageSteps' );
add_shortcode( 'step', 'instapageStep' );
add_shortcode( 'step_header', 'instapageStepHeader' );
add_shortcode( 'step_content', 'instapageStepContent' );
add_shortcode( 'divider', 'instapageDivider' );
add_shortcode( 'upgrade_button', 'upgradeButtonShortcode' );
add_shortcode( 'banner', 'bannerButtonShortcode' );
add_shortcode( 'quote', 'instapageQuoteShortcode' );
add_shortcode( 'ip_cta', 'ipCtaButtonShortcode' );
add_shortcode( 'ip_cta_image', 'ipCtaButtonShortcode' );
add_shortcode( 'trends', 'instapageGoogleTrendsShortcode' );
add_shortcode( 'soundcloud', 'instapageSoundcloudShortcode' );
add_action( 'admin_print_scripts', 'instapageAddEditorButtonsQt' );
add_shortcode( 'page_jump', 'pageJump' );

function getInstapageShortcodes()
{
  return array
  (
    'banner',
    'quote',
    'ip_cta',
    'ip_cta_image',
    'chapter_listing',
    'divider',
    'special_info',
    'important',
    'steps',
    'step',
    'step_header',
    'step_content',
    'page_jump'
  );
}

function shortcodesToExemptFromWptexturize( $shortcodes )
{
  $shortcodes = array_merge( $shortcodes, getInstapageShortcodes() );

  return $shortcodes;
}

function instapagePreShortcodeContentFilter( $content )
{

  global $post;

  if ( $post->post_type != 'seo-page' )
  {
    return $content;
  }

  $special_shortcodes = array
  (
    'chapter_listing',
    'divider'
  );

  $content = $post->post_content;
  $pattern = '/(\R*?)(\[.*?(' . implode( '|', $special_shortcodes ) . ').*?\])(\R*)/s';
  $replace = "\n\n$2\n\n";
  $content = preg_replace( $pattern, $replace, $content );

  $closing_shortcodes = array
  (

    'special_info',
    'steps',
  );

  $content = $post->post_content;
  $pattern = '/(\R*?)(\[(' . implode( '|', $closing_shortcodes ) . ')(\s*?\/?)\])/s';
  $replace = "\n\n$2";
  $content = preg_replace( $pattern, $replace, $content );

  $pattern = '/(\[\/(' . implode( '|', $closing_shortcodes ) . ')\])(\R*)/s';
  $replace = "$1\n\n";
  $content = preg_replace( $pattern, $replace, $content );

  $non_closing_shortcodes = array
  (
    'step'
  );

  $pattern = '/(\R*?)(\[(' . implode( '|', $non_closing_shortcodes ) . ')\s.*?\])(\R*)/s';
  $replace = "$2";
  $content = preg_replace( $pattern, $replace, $content );

  $pattern = '/\/(spep|steps)\](\R*?)\[(step|steps)/s';
  $replace = "$1][$2";
  $content = preg_replace( $pattern, $replace, $content );

  return $content;
}

function upgradeButtonShortcode( $atts, $content = null )
{
  $link = 'https://app.instapage.com/upgrade';

  if( !$content )
  {
    $button_text = __( 'Click here to upgrade now' );
  }
  else
  {
    $button_text = __( $content );
  }

  return '<a class="button upgrade-button" href="' . $link . '"><span class="button-text">' . $button_text . '</span><span class="button-arrow"></span></a>';
}

/**
 * Method for generating Google Trends for AMP
 *
 * @param int $height
 * @param int $width
 * @param string $query
 * @param string $geo
 * @return string
 */
function ampInstapageGoogleTrendsShortcode($height, $width, $query, $geo) {
  return '<span class="google-trends-embeded google-trends-embeded-amp">' .
  '<amp-iframe title="Interactive chart displaying 2016 Oscar Best Picture search interest by date"' .
  '  src="https://trends.google.com/trends/embed/explore/TIMESERIES?req=%7B%22comparisonItem%22%3A%5B%7B%22keyword%22%3A%22' . $query . '%22%2C%22geo%22%3A%22%22%2C%22time%22%3A%22all%22%7D%5D%2C%22category%22%3A0%2C%22property%22%3A%22%22%7D&amp;tz=-120&amp;eq=date%3Dall%26q%3D' . $query . '"' .
  '  height="366"' .
  '  layout="fixed-height"' .
  '  frameborder="0"' .
  '  sandbox="allow-scripts allow-same-origin">' .
  '</amp-iframe>' .
  '</span>';
}

function instapageGoogleTrendsShortcode($atts) {
  extract(
    shortcode_atts(
      [
        'w' => '500',
        'h' => '360',
        'q' => '',
        'geo' => 'US'
      ],
      $atts
    )
  );

  $h = (int) $h;
  $w = (int) $w;
  $q = esc_attr($q);
  $geo = esc_attr($geo);

  // if this shortcode is used in AMP context we output
  // diffrent version of google trends using amp tags
  if (isAmp()) {
    return ampInstapageGoogleTrendsShortcode($h, $w, $q, $geo);
  }

  return '<span class="google-trends-embeded"><script type="text/javascript" src="//www.google.com/trends/embed.js?hl=en-US&q=' . $q . '&content=1&cid=TIMESERIES_GRAPH_0&export=5&w=' . $w . '&h=' . $h . '"></script></span>';
}

function instapageSoundcloudShortcode( $atts )
{
  extract(
    shortcode_atts(
      array(
        'url' => '',
        'params' => '',
        'width' => '100%',
        'height' => '166',
        'iframe' => 'true'
      ),
      $atts
    )
  );

  $url = htmlentities( $url . '&' . $params );

  return '<iframe width="' . $width . '" height="' . $height . '" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=' . $url . '"></iframe>';
}

function instapageQuoteShortcode($atts, $content = null) {
  extract(
    shortcode_atts(
      [
        'author' => '',
        'author_role' => '',
        'link' => ''
      ],
      $atts
    )
  );
  $authorRole = $author_role;
  $authorHtml = '';
  $authorRoleHtml = '';
  $html = '<blockquote class="decorated"';

  if ($author) {
    $authorHtml = '<cite>' . $author . '</cite>';
  }

  if ($authorRole) {
    $authorRoleHtml = '<span> - </span>' . $authorRole;
  }

  if ($link && $link !== 'http://') {
    $html .= ' cite="'. $link .'" ';
    $authorHtml = $author ? '<a target="_blank" href="' . $link . '">' . $authorHtml . '</a>' : '';
  }

  $html .= '>' . '<p>' . $content . '</p>';

  if ($authorHtml || $authorRoleHtml ) {
    $html .= '<footer>' . $authorHtml . $authorRoleHtml . '</footer>';
  }

  $html .= '</blockquote>';

  return $html;
}

function bannerButtonShortcode( $atts, $content = null )
{
  $atts = shortcode_atts( array( 'url' => 'http://', 'img' => 'http://' ), $atts );
  $banner_url = $atts[ 'url' ];
  $banner_img = $atts[ 'img' ];

  return '<a class="banner" href="' . $banner_url . '"><img alt="' . __( 'Banner' ) . '" src="' . $banner_img . '" /></a>';
}

/**
 * Get data attributes for cta shortcode
 *
 * @param array $atts Attributes of cta shortcode
 *
 * @return string Data attributes for shortcode
 */
function getDataAttributesForCTA($atts = []) {
  $dataUrlTarget = isset($atts['url']) ? $atts['url'] : '';
  $currentUrl = get_permalink();
  static $orderNumber = 0; // Order number of CTA shortcode for current page, it can be treated as an ID
  $orderNumber++;

  return 'data-url-target="' . $dataUrlTarget . '" ' .
         'data-url-source="' . $currentUrl . '"' .
         'data-CTA="' . $orderNumber . '"';
}

/**
 * Get image tag from html string.
 *
 * @param string $htmlString
 *
 * @return string Image tag
 */
function getImageTagFromHtmlString($htmlString = '') {
    $matches = [];
    if (preg_match("#<img.*\/?>#", $htmlString, $matches)) {
      return $matches[0];
    }
    return '';
}

function ipCtaButtonShortcode($atts, $content = null, $tag) {
  $atts = shortcode_atts( array( 'url' => 'http://', 'text' => 'CTA button text', 'spacing_top' => '0', 'spacing_bottom' => '0', 'arrow' => 'true' ), $atts );
  $button_url = $atts[ 'url' ];
  $button_text = $atts[ 'text' ];
  $button_spacing_top = intval( $atts[ 'spacing_top' ] );
  $button_spacing_bottom = intval( $atts[ 'spacing_bottom' ] );
  $button_arrow = ( isset( $atts[ 'arrow' ] ) && $atts[ 'arrow' ] == 'false' ) ? false : true;
  $element_style= '';
  if ($tag === 'ip_cta_image') {
    $button_class = 'post-page-image-cta';
  } else {
    $button_class = "v7-btn v7-btn-cta is-on-top";
  }

  if( $button_spacing_top || $button_spacing_bottom )
  {
    $element_style .= ' style="';

    if( $button_spacing_top )
    {
      $element_style .= ' margin-top: ' . $button_spacing_top . 'px; ';
    }

    if( $button_spacing_bottom )
    {
      $element_style .= ' margin-bottom: ' . $button_spacing_bottom . 'px; ';
    }

    $element_style .= '" ';
  }

  if (is_null($content) || empty($content)) {
    if ($button_arrow) {
      $arrow_html = '<span class="button-arrow"></span>';
    }
    else {
      $arrow_html = '';
      $button_class .= ' no-arrow';
    }

    $content = '<span class="button-text">' . $button_text . '</span>' . $arrow_html;
  } else {
    // get only img tag from shortcode content
    $content = getImageTagFromHtmlString($content);
  }

  return '<a ' . $element_style . ' class="' . $button_class . '" href="' . $button_url . '" ' . getDataAttributesForCTA($atts) . '>' . $content . '</a>';
}

function instapageDivider( $atts, $content = null )
{
  $html .= '<hr />';

  return $html;
}

function specialInformation( $atts, $content = null )
{
  $content = trimTags( $content );
  $html .= '<div class="special-information">' . "\n";
  $html .= "\t" ."\t" .$content . "\n";
  $html .= '</div>' . "\n";

  return $html;
}

function instapageSteps( $atts, $content = null )
{
  $html = '</div>';
  $html .= '<section class="steps">';
  $html .= do_shortcode( $content );
  $html .= '</section>';
  $html .= '<div class="content">';

  return $html;
}

function instapageStep( $atts, $content = null )
{
  $atts = shortcode_atts( array( 'number' => '1' ), $atts );
  $step_number = $atts[ 'number' ];
  $content = trimTags( $content );
  $step_header = getShortcodeContent( 'step_header', $content );
  $step_content = getShortcodeContent( 'step_content', $content );
  $html = '<div class="step">';
  $html .= '<div class="content">';
  $html .= '<div class="step-header">';
  $html .= '<div class="step-number">' . __( 'step' ). ' <span class="number">' . $step_number. '</span></div>';

  if( $step_header != '' )
  {
    $html .= '<h2>' . $step_header . '</h2>';
  }

  $html .= '</div>';

  if( $step_content != '' )
  {
    $html .= '<div class="step-content">' . $step_content . '</div>';
  }

  $html .= '</div>';
  $html .= '</div>';

  return $html;
}

function instapageStepHeader( $atts, $content = null )
{
  return $content;
}

function instapageStepContent( $atts, $content = null )
{
  return $content;
}

function getShortcodeContent( $shortcode, $content )
{
  $pattern = '/\[' . $shortcode . '.*?\](.*?)\[\/' . $shortcode . '\]/s';
  $matches = null;
  $shortcode_content = '';

  if( preg_match( $pattern, $content, $matches ) )
  {
    $shortcode_content = $matches[ 1 ];
  }

  return $shortcode_content;
}

function seoPageChapterListing( $atts, $content = null )
{
  global $post;

  if ( $post->post_type != 'seo-page' )
  {
    return '';
  }

  return getSeoPageChaptersHtml( $post );
}

function instapageEditorButtons()
{
  add_filter( "mce_external_plugins", "instapageAddEditorButtons" );
  add_filter( 'mce_buttons', 'instapageRegisterEditorButtons' );
}

function instapageAddEditorButtons( $plugin_array )
{
  $plugin_array[ 'instapage_buttons' ] = get_template_directory_uri() . '/shortcodes/instapage-shortcodes-tmce.js' ;

  return $plugin_array;
}

function instapageRegisterEditorButtons( $buttons )
{
  $buttons = array_merge( $buttons, getInstapageShortcodes() );

  return $buttons;
}

function instapageAddEditorButtonsQt()
{
  wp_enqueue_script( 'instapage_custom_quicktags', get_template_directory_uri() . '/shortcodes/instapage-shortcodes-qt.js' , array( 'quicktags' ) );
}

function pageJump($shortcode, $content) {
  $pattern = '/<a\b((?=[^>]* class="(?<=[" ])(?<class>[^"]*)[" ]).*?)?(?=[^>]* href="(?<href>[^"]*)).*?>(?<text>[^"]*)<\/a/';
  $href = '';
  $class = null;
  $nextClass = null;
  $text = '';
  $jumpTwoLvlList = '<div class="quick-links panel panel-block"><h5>Quick Links</h5><ol class="quick-links-list">';

  preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
  $matchesCount = count($matches);

  for ($i = 0; $i < $matchesCount; ++$i ) {
    $match = $matches[$i];
    $href = $match['href'];
    $class = chooseListLevel($match['class']);
    $text = $match['text'];
    $nextClass = 'level-1';

    if ($i < $matchesCount - 1) {
      $nextClass = chooseListLevel($matches[$i + 1]['class']);
    }

    $jumpTwoLvlList = $jumpTwoLvlList . '<li class="' . $class . '"><a href="' . $href . '" title="' . $text . '">' . $text . '</a>';

    if (strpos($class, 'level-1') !== false) {
      if (strpos($nextClass, 'level-1') !== false) {
        $jumpTwoLvlList = $jumpTwoLvlList . '</li>';
      }

      if (strpos($nextClass, 'level-2') !== false) {
        $jumpTwoLvlList = $jumpTwoLvlList . '<ul class="lvl-2">';
      }
    }

    if (strpos($class, 'level-2') !== false) {
      if (strpos($nextClass, 'level-1') !== false) {
        $jumpTwoLvlList = $jumpTwoLvlList . '</li></ul>';
      }

      $jumpTwoLvlList = $jumpTwoLvlList . '</li>';
    }
  }

  $jumpTwoLvlList = $jumpTwoLvlList . '</ol></div>';

  return $jumpTwoLvlList;
}

function chooseListLevel($str) {
  if (strpos($str, 'level-1') !== false) {
    return 'level-1';
  } elseif (strpos($str, 'level-2') !== false) {
    return 'level-2';
  } else {
    return 'level-1';
  }
}
