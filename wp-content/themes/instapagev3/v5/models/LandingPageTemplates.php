<?php
namespace Instapage\Models;

use \Instapage\Classes\Templates\ClassTemplates;
use \Instapage\Helpers\StringHelper;

/**
 * Model for /landing-page-templates and /landing-page-templates/* pages
 */
class LandingPageTemplates extends Root {
  /**
   * @var string $archiveSlug Slug of template listing.
   */
  public $archiveSlug = 'landing-page-templates';

  /**
   * Gets list of categories from API
   * @uses   \Instapage\Classes\Templates\ClassTemplates::getCategories()
   * @return array
   */
  public function getCategories() {
    $items = [];

    $items[] = [
      'id' => 'all',
      'name' => 'All layouts',
      'url' => '#category-all',
      'class' => 'js-filter-single',
      'attributes' =>
      [
        'data-category' => 'all'
      ]
    ];

    $categories = ClassTemplates::getInstance()->getCategories();

    if ((is_array($categories)) && (!empty($categories))) {
      foreach ($categories as $category) {
        $dataCategory = 'js-template-' . $category->id;
        $items[] = [
          'id' => $category->id,
          'name' => $category->name,
          'url' => '#' . $dataCategory,
          'class' => 'js-filter-single',
          'attributes' =>
          [
            'data-category' => $dataCategory
          ]
        ];
      }
    }

    return $items;
  }

  /**
   * Gets list of templates from API
   * @uses   \Instapage\Classes\Templates\ClassTemplates::getTemplates()
   * @uses   self::isListingViewReady()
   * @uses   self::isDetailedViewReady()
   * @return array
   */
  public function getTemplates() {
    $templatesSource = ClassTemplates::getInstance()->getTemplates();
    $templates = [];
    
    /**
     * Remember that objects get assigned by reference. If you have
     * an array of object and make copy of this array, when you'll be modifing the object of new array
     * you we will be modyfing the same objects and the old array will have also modified valuees!
     */
    if ((!empty($templatesSource)) && (is_array($templatesSource))) {
      foreach ($templatesSource as $singleTemplateSource) {
        // we're creating new objects,
        // as for view we need to have a little bit diffrent verions of them, we cannot work on reference
        $template = clone $singleTemplateSource;
        
        $slug = (empty($template->slug)) ? StringHelper::toSlug($template->name) : $template->slug;
        $template->slug = $this->archiveSlug . '/' . $slug;
        $classes = [];
        if ((isset($template->categories)) && (!empty($template->categories))) {
          foreach ($template->categories as $category) {
            $classes[] = 'js-template-' . $category;
          }
        }
        $template->class = implode(' ', $classes);
        $template->showInListing = $this->isListingViewReady($template);
        $template->showDetailed = $this->isDetailedViewReady($template);
        if (!$template->showDetailed) {
          $template->slug = $this->archiveSlug . '/#';
        }
        
        // get assignment
        $templates[] = $template;
      }
    }
    
    return $templates;
  }

  /**
   * Gets single template from API
   * @param  string $slug
   * @param  bool $withNeighbours
   * @uses   \Instapage\Classes\Templates\ClassTemplates::getTemplate()
   * @return array
   */
  public function getTemplate($slug, $withNeighbours = false) {
    return ClassTemplates::getInstance()->getTemplate($slug, $withNeighbours);
  }

  /**
   * Sets the canonical URL.
   * @param string $canonical Previous canonical
   * @return  string Modified canonical for single template.
   */
  public function setCanonical($canonical) {
    return site_url($this->archiveSlug . '/' . ClassTemplates::getCurrentTemplateSlug());
  }

  /**
   * Gets similar templates from API
   * @param  object $template
   * @param  int $count
   * @uses   self::getTemplates()
   * @uses   self::isDetailedViewReady()
   * @return array
   */
  public function getSimilarTemplates($template, $count = 5) {
    $categories = $template->categories;
    if (empty($categories)) {
      return [];
    }

    $similarTemplates = [];
    $allTemplates = $this->getTemplates();
    foreach ($allTemplates as $singleTemplate) {
      if (
        ($template->id !== $singleTemplate->id) &&
        (!empty(array_intersect($singleTemplate->categories, $categories))) &&
        $this->isDetailedViewReady($singleTemplate)
      ) {
        $similarTemplates[] = $singleTemplate;
      }
    }

    return array_slice($similarTemplates, 0, $count);
  }

  /**
   * Checks if a template has all the necessary data to have a detailed view.
   * @param  object $template
   * @uses   \Instapage\Classes\Templates\ClassTemplates::isDetailedViewReady()
   * @return  bool
   */
  public function isDetailedViewReady($template) {
    return ClassTemplates::getInstance()->isDetailedViewReady($template);
  }

  /**
   * Checks if a template has all the necessary data to be shown in listing view.
   * @param  object $template
   * @uses   \Instapage\Classes\Templates\ClassTemplates::isListingViewReady()
   * @return  bool
   */
  public function isListingViewReady($template) {
    return ClassTemplates::getInstance()->isListingViewReady($template);
  }

  /**
   * Return dimensions of images for AMP template
   * @param  string
   * @return array
   */
  public function getImageSize($imageLink) {
    $width = '';
    $height = '';
    $schema = parse_url($imageLink, PHP_URL_SCHEME);
    $finalLink = (!is_null($schema)) ? $imageLink : 'http:' . $imageLink;

    list($width, $height) = getimagesize($finalLink);
    
    return [$width, $height];
  }
}
