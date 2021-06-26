<?php
namespace Instapage\Models;

/**
 * Model for /pricing page
 */
class Plans extends Root {
  /**
   * @var integer|boolean  Source post ID, it is useful for creating pricing experiment
   */
  protected $sourcePostID = false;

  /**
   *
   * @param integer|boolean $postID
   * @return boolean
   */
  public function setSourcePost($postID = false) {
    if (is_int($postID) || $postID === false) {
      $this->sourcePostID = $postID;
      return true;
    }
    return false;
  }

  /**
   * Gets an array with benefits from ACF
   * @return array
   */
  public function getBenefits() {
    $items = [];

    if (have_rows('benefits', $this->sourcePostID)) {
      while (have_rows('benefits', $this->sourcePostID)) {
        the_row();
        $items[] = [
          'name' => get_sub_field('name'),
          'description' => get_sub_field('description'),
          'icon' => get_sub_field('icon'),
          'smallHeadline' => true
        ];
      }
    }

    return $items;
  }

  /**
   * Gets an array with pricing plans from ACF
   *
   * @return array
   */
  public function getPricing() {
    $monthly = get_field('monthly', $this->sourcePostID);
    $annual = get_field('annual', $this->sourcePostID);
    $plans['monthly']= is_array($monthly) ? $monthly : [];
    $plans['annual'] = is_array($annual) ? $annual : [];

    return $plans;
  }

  /**
   * Gets an arary with price packages comparision
   *
   * @return array
   */
  public function getPackageComparison() {
    $columnNames = get_field('column_names', $this->sourcePostID);
    $features = get_field('features', $this->sourcePostID);
    $packageComparison['column_names'] = is_array($columnNames) ? $columnNames : [];
    // we expect array, if custom field is not defined there will be null,
    // so we return empty array for foreach
    $rawFeatures = is_array($features) ? $features : [];
    $processedFeatures = [];

    foreach ($rawFeatures as $rawFeature) {
      $featureRow = [
        'tooltip_text' => $rawFeature['tooltip_text'],
        'feature_name' => $rawFeature['feature_name'],
        // removing first two elements, it is feature name and tooltip
        // in this field we will be storing only booleans for featur availbilities
        'feature_availbilities' => array_slice($rawFeature, 2)
      ];

      $processedFeatures[] = $featureRow;
    }
    $packageComparison['features'] = $processedFeatures;

    return $packageComparison;
  }
}
