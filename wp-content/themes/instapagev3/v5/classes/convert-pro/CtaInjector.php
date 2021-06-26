<?php

namespace Instapage\Classes\ConvertPro;

/**
 * Class CtaInjector is responsible for injecting Convert Pro CTAs
 * into post content based on CTA setup page settings.
 *
 * @package Instapage\Classes\ConvertPro
 */
class CtaInjector {
  private $contentStage;
  private $topic;
  private $product;
  private $ctaId;
  const REPEATER_CACHE_KEY = 'cta-repeater';

  public function __construct() {
    add_filter(
      'the_content',
      [$this, 'injectCtaToContentIfNecessary']
    );
    add_action(
      'acf/save_post',
      [$this, 'clearCtaSetupRepeaterCache']
    );
  }

  /**
   * Get content stage set for current post.
   *
   * @return string
   */
  private function getContentStage() : string {
    if ($this->contentStage === null) {
      return $this->contentStage = (string) get_field('content_stage');
    }

    return $this->contentStage;
  }

  /**
   * Get topic for current post.
   *
   * @return string
   */
  private function getTopic() : string {
    if ($this->topic === null) {
      return $this->topic = (string) get_field('topic');
    }

    return $this->topic;
  }

  /**
   * Get product related to current post.
   *
   * @return string
   */
  private function getProduct() : string {
    if ($this->product === null) {
      return $this->product = (string) get_field('product');
    }

    return $this->product;
  }

  /**
   * Gets the CTA repeater from options. Tries to pull the data from cache at first.
   * 
   * @uses \Instapage\Classes\Factory::getCache()
   * @return array An array containing a CTA setup repeater repeater.
   */
  private function getCtaSetupRepeater() : array {
    $cache = \Instapage\Classes\Factory::getCache();
    
    if ($cpSetupRepeater = $cache::get(self::REPEATER_CACHE_KEY)) {
      return $cpSetupRepeater;
    }
    $cpSetupRepeater = get_field('cp_setup', 'options');

    if (!is_array($cpSetupRepeater)) {
      return [];
    }

    $cache::set(self::REPEATER_CACHE_KEY, $cpSetupRepeater);
    return $cpSetupRepeater;
  }
  /**
   * Gets the ConvertPro CTA ID for current post.
   * 
   * @return int CTA ID. Function returns 0 if no CTA should be displayed.
   */
  private function getCtaId() : int {
    if ($this->ctaId !== null) {
      return $this->ctaId;
    }

    $contentStage    = $this->getContentStage();
    $topic           = $this->getTopic();
    $product         = $this->getProduct();
    $cpSetupRepeater = $this->getCtaSetupRepeater();

    foreach($cpSetupRepeater as $row) {
      if (
           ($contentStage === $row['cp_content_stage'] || $row['cp_content_stage'] === 'all')
        && ($topic === $row['cp_topic'] || $row['cp_topic'] === 'all')
        && ($product === $row['cp_product'] || $row['cp_product'] === 'all')
        && !empty($row['cp_id'])
      ) {
        return  $this->ctaId = (int) $row['cp_id'];
      }
    }

    if (!$this->ctaId) {
      $this->ctaId = 0;
    }

    return $this->ctaId;
  }

  /**
   * Check if Convert Pro CTA should be injected into post content
   *
   * @return bool
   */
  public function shouldCtaBeInjected() : bool {
    /* @var $amp \Instapage\Classes\Amp\Amp */
    global $amp;

    return $this->getCtaId()
           && !$amp->isEnabled();
  }

  /**
   * Render Convert Pro CTA
   *
   * @param int $ctaId
   * @return string
   */
  private function renderCta(int $ctaId) : string {
    return do_shortcode('[cp_popup style_id="' . $ctaId . '" step_id = "1"][/cp_popup]');
  }

  /**
   * Inject proper CTA to the end of post content
   *
   * @param string $content
   * @return string
   */
  private function injectProperCta(string $content) : string {
    $content .= $this->renderCta($this->getCtaId());

    return $content;
  }

  /**
   * Inject Convert Pro CTA to the post content if neccessary.
   *
   * @param string $content Content of the post, this should come from filter
   * @return string Altered or not content of the post
   */
  public function injectCtaToContentIfNecessary(string $content) : string {
    if ($this->shouldCtaBeInjected()) {
      return $this->injectProperCta($content);
    }

    return $content;
  }

  /**
   * Clears CTA Setup repeater cache after saving the option page.
   * 
   * @param int|string $postId the ID of the post (or user, term, etc) being saved.
   */
  public function clearCtaSetupRepeaterCache($postId) {
    if ($postId === 'options') {
      $cache = \Instapage\Classes\Factory::getCache();
      $cache::delete(self::REPEATER_CACHE_KEY);
    }
  }
}
