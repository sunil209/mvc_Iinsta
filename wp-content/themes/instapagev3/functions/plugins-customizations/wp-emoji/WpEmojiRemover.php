<?php

namespace Instapage\PluginsCustomizations\WpEmoji;

class WpEmojiRemover {

  /**
   * Remove all actions associated with WP Emoji functionality
   */
  private function removeActions() : void {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
  }

  /**
   * Remove all filters associated with WP Emoji functionality
   */
  private function removeFilters() : void {
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  }

  /**
   * Modify some filters to cut off emoji handling
   */
  private function addFilters() : void {
    add_filter('tiny_mce_plugins', [$this, 'removeEmojisFromTinymce']);
    add_filter('wp_resource_hints', [$this, 'emojisRemoveDnsPrefetch'], 10, 2);
  }

  /**
   * Remove from TinyMCE WP Emoji plugin
   *
   * @param $tinymcePlugins
   * @return array
   */
  public function removeEmojisFromTinymce($tinymcePlugins) : array {
    if (is_array($tinymcePlugins)) {
      return array_diff($tinymcePlugins, ['wpemoji']);
    } else {
      return [];
    }
  }

  /**
   * Remove hint for prefetching emoji svg
   *
   * @param array $urls
   * @param string $relationType
   */
  public function emojisRemoveDnsPrefetch(array $urls, string $relationType) : array {
    if ($relationType === 'dns-prefetch') {
      $emojiSvgUrl = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
      $urls = array_diff($urls, [$emojiSvgUrl]);
    }

    return $urls;
  }

  /**
   * Disable all WP Emoji functionalities, only function which can be called directly
   */
  public function activate() : void {
    $this->removeActions();
    $this->removeFilters();
    $this->addFilters();
  }
}
