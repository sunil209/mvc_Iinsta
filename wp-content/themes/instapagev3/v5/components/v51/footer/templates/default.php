<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $class       CSS class
 * @param array  $attributes  Associative array of attributes
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;
?>

<footer
  class="v7 main-footer v7-content <?= isset($class) ? $class : '' ;?>"
  <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>
>
  <section class="main-footer-main">
    <?php
      Component::render('v51/footer-menu', ['title' => __('Products'), 'items' => getV5Menu('v5-footer-product-menu')]);
      Component::render('v51/footer-menu', ['title' => __('Solutions'), 'items' => getV5Menu('v5-footer-partners-menu')]);
      Component::render('v51/footer-menu', ['title' => __('Resources'), 'items' => getV5Menu('v5-footer-resource-menu')]);
      Component::render('v51/footer-menu', ['title' => __('Support'), 'items' => getV5Menu('v5-footer-support-menu')]);
      Component::render('v51/footer-menu', ['title' => __('Company'), 'items' => getV5Menu('v5-footer-company-menu')]);
    ?>
  </section>
  <hr class="horizontal-separator main-footer-separator">
  <div class="main-footer-social-wrapper">
    <div class="main-footer-social">
      <a href="https://www.linkedin.com/company/instapage" target="_blank" class="main-footer-link">
        <span class="main-footer-social-icon">
          <img src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-linkedin-white.svg" alt="">
        </span>
      </a>
      <a href="https://www.facebook.com/Instapageapp" target="_blank" class="main-footer-link">
        <span class="main-footer-social-icon">
          <img src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-facebook-white.svg" alt="">
        </span>
      </a>
      <a href="https://twitter.com/Instapage" target="_blank" class="main-footer-link">
        <span class="main-footer-social-icon">
          <img src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-twitter-white.svg" alt="">
        </span>
      </a>
      <a href="https://www.youtube.com/c/instapage" target="_blank" class="main-footer-link">
        <span class="main-footer-social-icon">
          <img src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-youtube-white.svg" alt="">
        </span>
      </a>
    </div>
    <span class="main-footer-copy-text">&copy; <?= date('Y'); ?> <?= __('Postclick, Inc. All Rights Reserved.'); ?></span>
  </div>
</footer>
