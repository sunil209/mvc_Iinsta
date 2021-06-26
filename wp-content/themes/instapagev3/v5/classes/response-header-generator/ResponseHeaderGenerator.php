<?php

namespace Instapage\Classes\ResponseHeaderGenerator;

class ResponseHeaderGenerator {
  /**
   * Global entrypoint for setting headers
   */
  public function setHeaders() : void {
    $this->setCacheHeaders();
  }

  /**
   * This method is called when full WordPress Environement is avaialable
   */
  public function setHeadersWithFullWpEnvironment() : void {
    $this->setCacheForPasswordProtected();
  }

  /**
   * Set headers associated with caching
   */
  private function setCacheHeaders() : void {
    $this->setGlobalCacheHeaders();
    $this->setCacheHeadersForAdminRelatedParts();
    $this->setCacheHeadersForRssFeed();
    $this->setCacheHeadersForWpRedirect();
  }

  /**
   * Rules which are applied to all request handled by wordpress
   */
  private function setGlobalCacheHeaders() : void {
    header('Cache-control: public, must-revalidate');
  }

  /**
   * No cache for admin related parts, where we should not cache responses
   */
  private function setCacheHeadersForAdminRelatedParts() : void {
    if (
      stripos($_SERVER['REQUEST_URI'], '/wp-admin') !== false
      || stripos($_SERVER['REQUEST_URI'], '/wp-login') !== false
      || stripos($_SERVER['REQUEST_URI'], 'preview=true') !== false
      || stripos($_SERVER['REQUEST_URI'], '/service-worker.js') !== false
    ) {
      $this->disableCache($private = true);
    }
  }

  /**
   * Set proper headers for CDN when user viewing password protected page
   */
  private function setCacheForPasswordProtected() : void {
    $post = get_post();

    if (!empty($post->post_password)) {
      $this->disableCache();
    }
  }

  /**
   * No cache for feed - instapage.com/feed
   */
  private function setCacheHeadersForRssFeed() : void {
    $feedSlugRegex = '#^/feed/?$#';
    if (preg_match($feedSlugRegex, $_SERVER['REQUEST_URI']) === 1) {
      $this->disableCache();
    }
  }

  /**
   * We do not want to have 302 redirects cached in CDN, it cause problems for outsider persons
   */
  private function setCacheHeadersForWpRedirect() : void {
    add_filter(
      'wp_redirect_status',
      function ($status, $location) {
        if ($status === 302) {
          $this->disableCache();
        }

        return $status;
      },
      10,
      2
    );
  }

  /**
   * Header which disable cache - browser & CDN
   */
  private function disableCache(?bool $private = false) : void {
    header('Cache-control: ' . ($private ? 'private, ' : '') . 'no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
  }
}
