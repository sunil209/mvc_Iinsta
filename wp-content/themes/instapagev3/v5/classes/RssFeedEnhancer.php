<?php

namespace Instapage\Classes;

/**
 * RssFeedEnhancer class is responsible for enhancing rss feed for custom needs of Instapage
 *
 */
class RssFeedEnhancer {
  use \Instapage\Traits\Singleton;

  /**
   * @var boolean Does our rss feed was enhanced?
   */
  private $enhanced = false;

  /**
   * Make all needed enhancment for rss feed.
   */
  public function enhance() {
    if (!$this->enhanced && is_feed()) {
      $this->hookFilters();
      $this->removeGeneratorVersion();
    }
  }

  /**
   * Method for hooking all necessary utility
   * to perform on proper events during wordpress working
   */
  private function hookFilters() {
    \add_filter('wp_title_rss', [$this, 'setTitle']);
    \add_filter('the_excerpt_rss', [$this, 'filterRssDescription']);
    \add_filter('wp_trim_words', [$this, 'reformatExcerpt'], 10, 4);
  }

  /**
   * Setting proper title for rss.
   * Set the RSS feed title to the value of /blog meta title.
   *
   * @return string Title for RSS feed
   */
  public function setTitle() {
    // at first we're trying to get title from yoast settings for blog
    $rssTitle = get_post_meta(get_option('page_for_posts'), '_yoast_wpseo_title', true);

    // but if for some reason yoast doesnt have title for blog
    // return title set by wordpress native functionality
    if (empty($rssTitle)) {
      $rssTitle = get_the_title(get_option('page_for_posts'));
    }

    $rssTitleEscaped = htmlspecialchars($rssTitle, ENT_XML1, 'UTF-8');
    // and add necessary suffix
    return $rssTitleEscaped . ' - Instapage';
  }

  /**
   * Removing no needed attributes from rss description.
   *
   * @param string $description Input description.
   *
   * @return string Modified description by needed filters
   */
  public function filterRssDescription($description) {
    $regexPatterns = [
      'srcset' => '#\s?srcset="[^"]+"#',
      'sizes' => '#\s?sizes="[^"]+"#'
    ];

    return preg_replace($regexPatterns, '', $description);
  }

  /**
   * Remove comment like <!-- generator="WordPress/4.9.6" --> from source of RSS
   */
  private function removeGeneratorVersion() {
    $rssHeaderActions = [
      'rss2_head',
      'commentsrss2_head',
      'rss_head',
      'rdf_header',
      'atom_head',
      'comments_atom_head',
      'opml_head',
      'app_head'
    ];

    // removing generator version from html comment in rss feed
    foreach ($rssHeaderActions as $action) {
      remove_action($action, 'the_generator');
    }
  }

  /**
   * Reformating RSS excerpt.
   *
   * Addign whitespace before read more link,
   * adding three dots at the end of excerpt when it isn't ended by full stop.
   * And checking if excerpt is really excerpt not just full text of post [for short posts]
   * Use in context of `wp_trim_words` filter
   *
   * @param string  $text          The trimmed text.
   * @param int     $numWords      The number of words to trim the text to. Default 55.
   * @param string  $more          An optional string to append to the end of the trimmed text, e.g. &hellip;.
   * @param string  $originalText  The text before it was trimmed.
   * @return string Reformatted excerpt
   */
  public function reformatExcerpt($text, $numWords, $more, $originalText) {
    $rawExcerpt = trim(str_replace($more, '', $text));
    $excerptLength = strlen($rawExcerpt);
    $orignalTextLength = strlen(trim(strip_tags($originalText)));

    // adding three dots and the of item description if it isn't ended by a full stop
    // and of course if excerpt is really excerpt (or maybe just full text)
    if (
       substr($rawExcerpt, -1) !== '.'
       && substr($rawExcerpt, -3) !== '...'
       && $excerptLength < $orignalTextLength
    ) {
      $rawExcerpt .= '...';
    }

    return $rawExcerpt . ' ' . $more;
  }
}
