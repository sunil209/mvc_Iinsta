<?php
namespace Instapage\Models;

/**
 * Model for /features page
 */
class Feature extends FeatureIntegration
{
    /**
     * @var string $postType Holds information about what postType should be used with this model
     */
    public $postType = 'feature';

    /**
     * @var string $relatedTaxonomy Holds name of related taxonomy
     */
    public $relatedTaxonomy = 'feature_category';

    /**
     * @var string $relatedPage Holds name of related page containing required ACF fields
     */
    public $relatedPage = 'static-features';
}
