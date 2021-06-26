<?php

namespace Instapage\Components\v70\AttributionTracker;

use Instapage\Classes\Data;

class AttributionTrackerLeadDecorator
{
    /** @var object */
    private $lead;
    /** @var array */
    private $attributionTrackerFieldNames;

    public function __construct(object $lead, array $attributionTrackerFieldNames)
    {
        $this->lead = $lead;
        $this->attributionTrackerFieldNames = $attributionTrackerFieldNames;
    }

    /**
     * Decorate lead send to Marketing Automation system about attribution tracking information. Useful to see
     * by which marketing campaign user visited our page and filled form
     */
    public function decorate(): void
    {
        $leadArray = (array)$this->lead;

        foreach ($this->attributionTrackerFieldNames as $fieldName => $CRMFieldName) {
            $fieldValue = Data::_stringFromPost($fieldName);

            if (empty($fieldValue)) {
                continue;
            }

            $leadArray[$CRMFieldName] = $fieldValue;
        }

        $this->lead = (object) $leadArray;
    }

    public function getLead(): object
    {
        return $this->lead;
    }
}
