<?php
/**
 * Template file. Template params are stored in $params array
 * $attributes  - associative array of attributes
 * $class       - CSS class added to `<section>`
 * $author      - Author
 * $quote       - Quote text
 * $url         - Twitter share url
 */

use Instapage\Helpers\HtmlHelper;
?>
<section class="<?= $class; ?> content division" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
  <?php if (isAmp()): ?>
    <amp-img 
      alt="Article quote" 
      src="<?= get_template_directory_uri(); ?>/v5/assets/images/article-quote.svg" 
      width="60" 
      height="60">
    </amp-img>
  <?php else: ?>
    <img src="<?= get_template_directory_uri(); ?>/v5/assets/images/article-quote.svg" alt="<?= __('Quote'); ?>">
  <?php endif; ?>
  <div class="heading-primary quote-tweet-text">
    <a href="<?= $url; ?>" target="_blank" rel="noopener noreferrer"><?= $quote; ?></a>
  </div>
  <span class="quote-tweet-author"><?= $author; ?></span>
  <a href="<?= $url; ?>" target="_blank" class="btn btn-cta is-small" rel="noopener noreferrer">
    <?php if (isAmp()): ?>
      <amp-img
        alt="Twitter icon"
        src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-twitter-white.svg"
        width="18"
        height="15">
      </amp-img>
    <?php else: ?>
      <img class="icon-click-to-tweet" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-twitter-white.svg" alt="">
    <?php endif; ?>
    <span><?= __('Tweet this'); ?></span>
  </a>
</section>
