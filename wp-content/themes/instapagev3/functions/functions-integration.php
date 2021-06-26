<?php
class Integration extends CustomPostType {
  public static $postType = 'integration';
  public static $nameSingular = 'integration';
  public static $namePlural = 'integrations';
  public static $slug = 'integrations';
  public static $hasArchive = true;

  public static function isIntegration($post = null) {
    return parent::is(null, $post);
  }
}

class IntegrationCategory extends CustomTaxonomy {
  public static $taxonomy = 'integration_category';
  public static $relatedPostTypes = ['integration'];
  public static $nameSingular = 'Category';
  public static $namePlural = 'Categories';
  public static $priority = 1;
}

new Integration();
new IntegrationCategory();
