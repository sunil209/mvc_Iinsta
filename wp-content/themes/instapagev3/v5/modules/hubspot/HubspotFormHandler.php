<?php

namespace Instapage\Modules\Hubspot;

use Instapage\Components\v70\AttributionTracker\AttributionTrackerHubspotFieldNames;
use Instapage\Components\v70\AttributionTracker\AttributionTrackerLeadDecorator;
use Instapage\Configs\HubspotConfiguration;
use Instapage\Modules\RequestContext\RequestContext;
use SevenShores\Hubspot\Factory;

class HubspotFormHandler
{
    /**
     * Hubspot API wants form fields values to have like:
     * each list entry will be an object containing "name":{field name} and "value":{field value} pairs.
     *
     * @see https://developers.hubspot.com/docs/methods/forms/submit_form
     *
     * @param object $lead Object containing lead, property name equals to field name,
     *                      property value equals to field value
     *
     * @return array Lead formatted with following data scheme from their doc.
     */
    public function formatLeadForHubspotAPI(object $lead): array
    {
        $leadArray = (array)$lead;
        $formattedLead = [];

        foreach ($leadArray as $fieldName => $fieldValue) {
            $formattedLead[] = [
                'name' => $fieldName,
                'value' => $fieldValue,
            ];
        }

        return [
            'fields' => $formattedLead,
        ];
    }

    /**
     * We enrrich lead by Hubspot sepcific information, like Hubspot User Token, Page Name, Page Url etc.
     *
     * @see https://developers.hubspot.com/docs/methods/forms/submit_form
     */
    private function enrichHubspotLead(array $lead): array
    {
        $requestContext = new RequestContext($_SERVER);
        $hubspotContextBuilder = new HubspotContextBuilder($requestContext, $_COOKIE);
        $lead['context'] = $hubspotContextBuilder->build();

        return $lead;
    }

    /**
     * Collect data from form, format it properly and send it to Hubspot. This method should be called on validated
     * form.
     */
    public function handleFormToHubspot(object $lead, string $formID): void
    {
        $hubspot = Factory::create(HubspotConfiguration::API_KEY);

        $leadDecorator = new AttributionTrackerLeadDecorator(
            $lead,
            AttributionTrackerHubspotFieldNames::FIELDS
        );
        $leadDecorator->decorate();
        $decoratedLead = $leadDecorator->getLead();
        $formattedLead = $this->formatLeadForHubspotAPI($decoratedLead);
        $enrichedLead = $this->enrichHubspotLead($formattedLead);

        $hubspot->forms()->submit(
            HubspotConfiguration::PORTAL_ID,
            $formID,
            $enrichedLead
        );
    }

}
