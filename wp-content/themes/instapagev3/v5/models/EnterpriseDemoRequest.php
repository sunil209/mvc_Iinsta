<?php

namespace Instapage\Models;

use \Instapage\Classes\Data;
use \Instapage\Classes\Forms\{
    Form,
    FormResponse
};
use Instapage\Configs\HubspotConfiguration;
use \Instapage\Forms\EnterpriseDemoRequestForm;
use Instapage\Modules\Hubspot\HubspotFormHandler;
use Instapage\Modules\RequestContext\RequestContext;
use \Instapage\Modules\Segment\SegmentContextBuilder;

/**
 * Model for /enterprise-demo-request page
 */
class EnterpriseDemoRequest extends Root
{
    const NONCE_TOKEN_NAME = 'enterprise-demo-request';

    /**
     * Get nonce token name, useful for genrating and checking nonces
     *
     * @return string
     */
    public function getNonceTokenName(): string
    {
        return self::NONCE_TOKEN_NAME;
    }

    /**
     * Handles form submissions and sends them to CRM system
     * @return array
     */
    public function handleFormSubmit(): array
    {
        $formResponse = new FormResponse();
        $enterpriseDemoRequestForm = new EnterpriseDemoRequestForm();
        $formFields = $enterpriseDemoRequestForm->getFields();

        if (!empty($_POST)) {
            $requiredFields = $enterpriseDemoRequestForm->getRequiredFields();
            $form = new Form($requiredFields, $this->getNonceTokenName());

            if ($form->isFormValid()) {
                try {
                    $hubspotFormHandler = new HubspotFormHandler();
                    $hubspotFormHandler->handleFormToHubspot(
                        $enterpriseDemoRequestForm->prepareHubspotLeadFromFormData(),
                        HubspotConfiguration::FORM_ID_ENTERPRISE_DEMO_REQUEST
                    );

                    $requestContext = new RequestContext($_SERVER);
                    $segmentContextBuilder = new SegmentContextBuilder($requestContext, $_COOKIE);

                    require_once(__DIR__ . '../../libraries/segment/lib/Segment.php');
                    \Segment::init('9N0peU5oWLnsE151CaXjJSKB1WJaqpiq');
                    \Segment::track([
                        'userId' => Data::_stringFromPost('email'),
                        'event' => 'Submitted Successfully',
                        'properties' => [
                            'category' => 'Multistep form',
                            'label' => 'Enteprise demo request',
                            'value' => '10',
                        ],
                        'integrations' => [
                            'Google Analytics' => [
                                'clientId' => $segmentContextBuilder->getGoogleAnalyticsClientId()
                            ]
                        ],
                        'context' => $segmentContextBuilder->build()
                    ]);

                    $formResponse->setSuccess();
                    wp_redirect(get_permalink(get_page_by_path('enterprise-thank-you')), 303);
                    exit;
                } catch (\Exception $e) {
                    error_log($e);
                    $formFields = $enterpriseDemoRequestForm->getOldData();
                    $formResponse->setError();
                }
            } else {
                error_log('Tried to submit an invalid form');
                // return data that user filled in, it is easier to fix already submitted data than submiting once again
                $formFields = $enterpriseDemoRequestForm->getOldData();
                $formResponse->setError();
            }

        }
        $formResponse->setFields($formFields);

        return $formResponse->returnResponse();
    }
}
