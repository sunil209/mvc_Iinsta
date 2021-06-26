<?php
namespace Instapage\Classes;

/**
 * Class Holding all modification and improvements for ACF
 */
class AdvancedCustomFieldsTweaks {

  const CONTENT_STAGE_FIELD_KEY = 'field_5b3638d50bc44';
  const TOPIC_FIELD_KEY         = 'field_5bf3f934e84b8';
  const PRODUCT_FIELD_KEY       = 'field_5c0653abcbb88';

  /**
   * Method for creating acf select with all post types.
   *
   * This method can be called only from filet by ACF
   *
   * @param array $field  Field definition - comes from ACF filter.
   * @return array $field Modified field about post types list
   */
  public static function registerACFWithPostTypesList(array $field) {
    // reset choices
    $field['choices'] = [];

    // $args for asking for post types list
    $args = [
      'public'   => true,
      '_builtin' => false,
    ];
    $postTypes = get_post_types($args, 'objects');

    foreach ($postTypes as $postType) {
      $field['choices'][$postType->name] = $postType->label;
    }

    // return the modified field
    return $field;
  }

  /**
   * Gets the choices from defined Select type ACF field.
   * @param string Field key. Important! Not a field name. To get the field key toggle display options in a ACF field group in admin panel.
   * 
   * @return array Array of choices.
   */
  private static function getFieldChoices(string $fieldKey) : array {
    $field = get_field_object($fieldKey);
    return $field['choices'] ?? [];
  }
  
  /**
   * Register a field with all the available content stages & "All" choice.
   * @param array $field  Field definition - comes from ACF filter.
   * @return array Field array.
   */
  public static function registerAvailableContentStages(array $field) : array {
    $field['choices'] = array_merge(['all' => 'All'], self::getFieldChoices(self::CONTENT_STAGE_FIELD_KEY));
    return $field;
  }

  /**
   * Register a field with all the available topics & "All" choice.
   * @param array $field  Field definition - comes from ACF filter.
   * @return array Field array.
   */
  public static function registerAvailableTopics(array $field) : array {
    $field['choices'] = array_merge(['all' => 'All'], self::getFieldChoices(self::TOPIC_FIELD_KEY));
    return $field;
  }

  /**
   * Register a field with all the available products & "All" choice.
   * @param array $field  Field definition - comes from ACF filter.
   * @return array Field array.
   */
  public static function registerAvailableProducts(array $field) : array {
    $field['choices'] = array_merge(['all' => 'All'], self::getFieldChoices(self::PRODUCT_FIELD_KEY));
    return $field;
  }

  /**
   * Register a field with all the available ConvertPro CTAs.
   * @uses CP_V2_Popups::get_all()
   * @param array $field  Field definition - comes from ACF filter.
   * @return array Field array.
   */
  public static function registerAvailableConvertProCta(array $field) : array {
    if (!class_exists('CP_V2_Popups')) {
      return $field;
    }

    $ctas = \CP_V2_Popups::get_all();
    if (!is_array($ctas)) {
      return $field;
    }
    $field['choices'] = [];

    foreach ($ctas as $cta) {
      if (!isset($cta->post_title) || !isset($cta->ID)) {
        continue;
      }
      $field['choices'][$cta->ID] = $cta->post_title . ' [ID: ' . $cta->ID . ']';
    }

    return $field;
  }
}
