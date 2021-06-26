<?php
namespace Instapage\Models;

/**
 * Model for /marketing-dictionary page
 */
class DictionaryTerm extends Root {

  /**
   * @var string $postType Holds information about what postType should be used with this model
   */
  public $postType = 'dictionary-term';
  public $postArchiveSlug = 'marketing-dictionary';

  /**
   * Returns ID of page from which ACF fields for header section should be taken from
   * @return int
   */
  public function getContextID() {
    return get_page_by_path($this->postArchiveSlug);
  }

  public function getFirstLetter($string) {
    return strtoupper(substr(trim($string), 0, 1));
  }

  public function getBarItems() {
    global $wpdb;

    $searchQuery = "SELECT post_title FROM wp_posts WHERE post_type = 'dictionary-term'";
    $results = $wpdb->get_results($searchQuery, OBJECT_K);
    $allLetters =  str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $availableLetters = [];
    $dictionaryBar = [];

    foreach ($results as $termName => $object) {
      $letter = getFirstLetter($termName);
      $availableLetters[$letter] = true;
    }

    foreach ($allLetters as $letter) {
      $barItem = [];
      $barItem['content'] = $letter;

      if (isset($availableLetters[$letter])) {
        $barItem['url'] = '#' . $letter;
      } else {
        $barItem['url'] = '#';
      }

      $dictionaryBar[] = $barItem;
    }

    return $dictionaryBar;
  }

  public function getListingItems() {
    $terms = get_posts(
      [
        'posts_per_page' => -1,
        'post_type'=>'dictionary-term',
        'orderby' => 'post_name',
        'order' => 'ASC'
      ]
    );

    $dictionaryListing = [];
    $currentLetter = '';

    foreach ($terms as $term) {
      $letter = getFirstLetter($term->post_title);
      $dictionaryListing[$letter][] = [
        'url' => get_permalink($term),
        'title' => $term->post_title,
        'hasVideo' => (getAcfVar('video_url', '', $term->ID) !== ''),
      ];
    }

    return $dictionaryListing;
  }

  public function getRelatedTermsObjects($termId) {
    $relatedTerms = get_field('related_terms', $termId);

    foreach ($relatedTerms as &$term) {
      $term->link = get_permalink($term);
    }

    return $relatedTerms;
  }

  public function cleanDictionaryKeywords($string) {
    return trim(str_replace(' ', '+',  $string));
  }

  public function getTrendsChart(int $termId): string
    {
        $googleTrendsKeywords = get_field('google_trends_keywords', $termId);

        if (empty($googleTrendsKeywords)) {
            return '';
        }

        $googleTrendsKeywordsArray = explode(',', $googleTrendsKeywords);
        $googleTrendsKeywordsArray = array_map('cleanDictionaryKeywords', $googleTrendsKeywordsArray);
        $code = '[trends w="940" h="400" q="' . implode(',', $googleTrendsKeywordsArray) . '" /]';

        return do_shortcode($code);
    }

    public function getClickToTweet($termId): array
    {
        $tweetContent = get_field('tweet_content', $termId, false);
        $dividerPosition = strpos($tweetContent, '|');

        if ($dividerPosition !== false) {
            $tweetAuthor = substr($tweetContent, $dividerPosition + 1);
            $tweetContent = substr($tweetContent, 0, $dividerPosition);
        }

        $code = '[Tweet "' . $tweetContent . '"]';
        $code = apply_filters('the_content', $code);

        $matches = [];
        preg_match('#href=(\"|\')([^\"\']+?)(\1)#', $code, $matches);
        $tweetUrl = $matches[2];

        return [
            'class' => 'quote-tweet',
            'author' => $tweetAuthor,
            'quote' => $tweetContent,
            'url' => $tweetUrl
        ];
    }

    public function getTermDefinition($termId): array
    {
        $title = get_the_title($termId);
        $subtitle = get_field('definition', $termId);

        return ['title' => $title, 'subtitle' => $subtitle];
    }

    public function getBreadCrumbsItems($termId): array
    {
        $dictionaryArchiveUrl = get_post_type_archive_link('dictionary-term');
        $termTitle = get_the_title($termId);
        $letterID = get_the_title($termId)[0];

        $breadCrumbsItems = [
            ['title' => __('Dictionary'), 'url' => $dictionaryArchiveUrl],
            ['title' => $letterID, 'url' => $dictionaryArchiveUrl . '#' . $letterID],
            ['title' => $termTitle]
        ];

        return $breadCrumbsItems;
    }

    public function getVideoUrl($termId): string
    {
        return (string) get_field('video_url', $termId);
    }

    public function getTweetContent($termId): string
    {
        return (string) get_field('tweet_content', $termId);
    }

    public function getGoogleTrends($termId): string
    {
        return (string) get_field('google_trends_keywords', $termId);
    }

}
