<?php

namespace Instapage\Forms;

use \Instapage\Classes\Data;

/**
 * Methods of this class should be put into interface/abstract class
 * if we will be having more forms handled in this way
 *
 * Class EnterpriseDemoRequestForm
 * @package Instapage\Forms
 */
class PartnerContactForm
{
    /**
     * Get fields definition for view and internal handling purpose
     *
     */
    public function getFields(): array
    {
        return [
            'first-name' => '',
            'last-name' => '',
            'email' => '',
            'company' => '',
            'website' => '',
            'message' => '',
            'policy-agreement' => ''
        ];
    }

    /**
     * Get submitted data by user
     */
    public function getData(): array
    {
        return [
            'firstName' => Data::_stringFromPost('first-name'),
            'lastName' => Data::_stringFromPost('last-name'),
            'email' => Data::_stringFromPost('email'),
            'company' => Data::_stringFromPost('company'),
            'website' => Data::_stringFromPost('website'),
            'message' => Data::_stringFromPost('message'),
            'policyAgreement' => Data::_stringFromPost('policy-agreement'),
        ];
    }

    /**
     * Prepare submitted data by user to show them in Form UI
     * (we need to have information about what fields where selected etc)
     */
    public function getOldData(): array
    {
        $formFields = $this->getFields();

        $formFields['first-name'] = Data::_post('first-name', '', FILTER_SANITIZE_STRING);
        $formFields['last-name'] = Data::_post('last-name', '', FILTER_SANITIZE_STRING);
        $formFields['email'] = Data::_post('email', '', FILTER_SANITIZE_EMAIL);
        $formFields['company'] = Data::_post('company', '', FILTER_SANITIZE_STRING);
        $formFields['website'] = Data::_post('website', '', FILTER_SANITIZE_STRING);
        $formFields['message'] = Data::_post('message', '', FILTER_SANITIZE_STRING);
        $formFields['policy-agreement'] = ((bool)Data::_post(
            'policy-agreement',
            '',
            FILTER_SANITIZE_STRING
        )) ? 'checked' : '';

        return $formFields;
    }

    public function getRequiredFields(): array
    {
        return [
            'first-name',
            'last-name',
            'email',
            'company',
            'website',
            'message',
            'policy-agreement'
        ];
    }

    public function prepareHubspotLeadFromFormData(): object
    {
        $formData = $this->getData();

        return (object)[
            'firstname' => $formData['firstName'],
            'lastname' => $formData['lastName'],
            'email' => $formData['email'],
            'company' => $formData['company'],
            'website' => $formData['website'],
            'temp_comments' => $formData['message'],
        ];
    }
}
