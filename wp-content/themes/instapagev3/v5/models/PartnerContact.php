<?php
namespace Instapage\Models;

use Instapage\Classes\Forms\Form;
use Instapage\Classes\Forms\FormResponse;
use Instapage\Configs\HubspotConfiguration;
use Instapage\Forms\PartnerContactForm;
use Instapage\Modules\Hubspot\HubspotFormHandler;

/**
 * Model for /partner-contact page
 */
class PartnerContact extends Root
{

    const NONCE_TOKEN_NAME = 'partner_nonce';

    /**
     * Get nonce token name, useful for genrating and checking nonces
     *
     * @return string
     */
    public function getNonceTokenName() : string
    {
        return self::NONCE_TOKEN_NAME;
    }

    /**
     * Handles form submissions and sends them to CRM system
     * @return array
     */
    public function handleFormSubmit() : array
    {
        $formResponse = new FormResponse();
        $partnerContactForm = new PartnerContactForm();
        $formFields = $partnerContactForm->getFields();

        if (!empty($_POST)) {
            $requiredFields = $partnerContactForm->getRequiredFields();
            $form  = new Form($requiredFields, $this->getNonceTokenName());

            if ($form->isFormValid()) {
                try {
                    $hubspotFormHandler = new HubspotFormHandler();
                    $hubspotFormHandler->handleFormToHubspot(
                        $partnerContactForm->prepareHubspotLeadFromFormData(),
                        HubspotConfiguration::FORM_ID_PARTNER_CONTACT
                    );

                    $formResponse->setSuccess();
                } catch (\Exception $e) {
                    error_log($e);

                    $formResponse->setError();
                }
            } else {
                error_log('Tried to submit an invalid form');
                $formResponse->setError();
            }

            if ($formResponse->getStatus() === FormResponse::STATUS_ERROR) {
                $formFields = $partnerContactForm->getOldData();
            }
        }
        $formResponse->setFields($formFields);

        return $formResponse->returnResponse();
    }
}
