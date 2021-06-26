<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $class       CSS class
 * @param array  $attributes  Associative array of attributes
 */

use \Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Component;
?>
<footer class="main-footer <?= isset($class) ? $class : '' ;?>" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
  <section class="main-footer-main content">
    <?php
      Component::render('amp/footer-menu', 'v51', ['title' => __('Product'), 'items' => getV5Menu('v5-footer-product-menu')]);
      Component::render('amp/footer-menu', 'v51', ['title' => __('Solutions'), 'items' => getV5Menu('v5-footer-partners-menu')]);
      Component::render('amp/footer-menu', 'v51', ['title' => __('Resources'), 'items' => getV5Menu('v5-footer-resource-menu')]);
      Component::render('amp/footer-menu', 'v51', ['title' => __('Support'), 'items' => getV5Menu('v5-footer-support-menu')]);
      Component::render('amp/footer-menu', 'v51', ['title' => __('Company'), 'items' => getV5Menu('v5-footer-company-menu')]);
    ?>
  </section>
  <div class="main-footer-social-wrapper content">
    <div class="main-footer-social">
      <a href="https://www.linkedin.com/company/instapage" target="_blank" class="main-footer-link">
        <span class="main-footer-social-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11">
            <path fill="#FFF" fill-rule="nonzero" d="M12 6.744V11H9.428V7.03c0-.998-.372-1.68-1.303-1.68-.71 0-1.134.46-1.32.903-.067.16-.085.38-.085.602V11H4.147s.035-6.725 0-7.422H6.72V4.63l-.017.024h.017V4.63c.342-.505.952-1.227 2.318-1.227C10.731 3.403 12 4.464 12 6.744zM1.456 0C.576 0 0 .554 0 1.282c0 .713.559 1.283 1.422 1.283h.017c.897 0 1.455-.57 1.455-1.283C2.877.554 2.336 0 1.456 0zM.153 11h2.572V3.578H.153V11z"/>
          </svg>
        </span>
      </a>
      <a href="https://www.facebook.com/Instapageapp" target="_blank" class="main-footer-link">
        <span class="main-footer-social-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12">
            <path fill="#FFF" fill-rule="nonzero" d="M6.599.002L4.954 0C3.106 0 1.912 1.16 1.912 2.953v1.362H.26A.252.252 0 0 0 0 4.56v1.973c0 .135.116.244.259.244h1.653v4.978c0 .136.116.245.259.245h2.158c.142 0 .258-.11.258-.245V6.777h1.934c.143 0 .258-.11.258-.244L6.78 4.56a.239.239 0 0 0-.076-.173.266.266 0 0 0-.183-.072H4.587V3.16c0-.555.14-.837.904-.837h1.108c.142 0 .258-.11.258-.245V.247A.252.252 0 0 0 6.6.002z"/>
          </svg>
        </span>
      </a>
      <a href="https://twitter.com/Instapage" target="_blank" class="main-footer-link">
        <span class="main-footer-social-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
            <path fill="#FFF" fill-rule="evenodd" d="M12 1.182c-.45.204-.926.338-1.414.397A2.52 2.52 0 0 0 11.668.183a4.877 4.877 0 0 1-1.562.615 2.42 2.42 0 0 0-2.702-.62 2.525 2.525 0 0 0-1.557 2.347c0 .194.021.387.064.576A6.931 6.931 0 0 1 .835.458c-.653 1.154-.32 2.63.762 3.37a2.402 2.402 0 0 1-1.115-.315v.033c0 1.201.827 2.236 1.975 2.475a2.402 2.402 0 0 1-1.112.044c.322 1.028 1.246 1.732 2.3 1.753A4.864 4.864 0 0 1 0 8.865 6.844 6.844 0 0 0 3.773 10 6.87 6.87 0 0 0 8.74 7.91a7.228 7.228 0 0 0 2.037-5.094c0-.11 0-.218-.008-.327.483-.357.9-.8 1.231-1.307z"/>
          </svg>
        </span>
      </a>
      <a href="https://www.youtube.com/c/instapage" target="_blank" class="main-footer-link">
        <span class="main-footer-social-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8">
            <path fill="#FFF" fill-rule="evenodd" d="M12 1.708a1.698 1.698 0 0 0-.532-1.214A1.807 1.807 0 0 0 10.206 0H1.793C.81-.008.009.757 0 1.708V6.29C.008 7.242.81 8.008 1.793 8h8.413c.472.004.926-.174 1.262-.495A1.7 1.7 0 0 0 12 6.29V1.708zM4.8 5.933V1.63L8.227 3.78 4.8 5.933z"/>
          </svg>
        </span>
      </a>
    </div>
    <span class="main-footer-copy-text">&copy; <?= date('Y'); ?> <?= __('Postclick, Inc. All Rights Reserved.'); ?></span>
  </div>
</footer>
