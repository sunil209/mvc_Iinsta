<?php
/**
 * Template file. Template params are stored in $params array
 * $attributes - associative array of attributes
 * $title      - text to be displayed in share bar as title
 * $singlePodcast  -  on single podcast page we don't need to have sticky social menu
 */

use Instapage\Helpers\HtmlHelper;
?>
<div class="js-navbar navbar-social" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
  <div class="js-social-container">
    <?php
      if (get_post_type() === 'podcast' && is_single()) {
        instapageSocialWidget('podcast');
      } else {
        instapageSocialWidget('v51');
      }
    ?>
  </div>
</div>

