<?php
class Feature extends CustomPostType {
  public static $postType = 'feature';
  public static $nameSingular = 'feature';
  public static $namePlural = 'features';
  public static $slug = 'features';
  public static $hasArchive = true;

  public static function isFeature($post = null) {
    return parent::is(null, $post);
  }
}

class FeatureCategory extends CustomTaxonomy {
  public static $taxonomy = 'feature_category';
  public static $relatedPostTypes = ['feature'];
  public static $nameSingular = 'Category';
  public static $namePlural = 'Categories';
  public static $priority = 1;
}

new Feature();
new FeatureCategory();
