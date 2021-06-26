<?php

require_once(get_template_directory() . '/functions/plugins-customizations/wp-emoji/WpEmojiRemover.php');

use Instapage\PluginsCustomizations\WpEmoji\WpEmojiRemover;

add_action('init', function () {
  (new WpEmojiRemover())->activate();
});
