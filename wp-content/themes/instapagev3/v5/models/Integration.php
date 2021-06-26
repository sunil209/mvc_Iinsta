<?php
namespace Instapage\Models;

/**
 * Model for /integrations page
 */
class Integration extends FeatureIntegration
{
    /**
     * @var string $postType Holds information about what postType should be used with this model
     */
    public $postType = 'integration';

    /**
     * @var string $relatedTaxonomy Holds name of related taxonomy
     */
    public $relatedTaxonomy = 'integration_category';

    /**
     * @var string $relatedPage Holds name of related page containing required ACF fields
     */
    public $relatedPage = 'static-integrations';

    /**
     * @var array $tags Holds different tags for types of integrations
     */
    public $tags = [
        [
            'name' => 'All Types',
            'value' => ''
        ],
        [
            'name' => 'Native',
            'value' => 'native'
        ],
        [
            'name' => 'Custom Code',
            'value' => 'custom'
        ],
        [
            'name' => 'Enabled via Zapier',
            'value' => 'zapier'
        ],
        [
            'name' => 'Enabled via Webhooks',
            'value' => 'webhooks'
        ],
    ];

    /**
     * @var array $allCategories Holds empty category for resetting filter
     */
    public $allCategories = [
        [
            'id' => '',
            'name' => 'All Categories',
            'url' => ''
        ],
    ];
}
