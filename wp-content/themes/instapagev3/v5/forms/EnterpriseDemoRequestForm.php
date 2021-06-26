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
class EnterpriseDemoRequestForm
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
            'phone-number' => '',
            'message' => '',
            'company' => '',
            'company-size-select' => [
                '' => '',
                '1-50' => '',
                '51-200' => '',
                '201-400' => '',
                '401-1000' => '',
                '1001-10000' => '',
                '10000+' => '',
            ],
            'job-select' => [
                '' => '',
                'PPC/SEM' => '',
                'CRO' => '',
                'Growth' => '',
                'Digital Marketing' => '',
                'Demand Generation' => '',
                'Design' => '',
                'Copywriting' => '',
                'Email & Lifecycle' => '',
                'Operations' => '',
                'Others' => '',
            ],
            'seniority-select' => [
                '' => '',
                'Owner/Founder' => '',
                'Executive' => '',
                'VP' => '',
                'Director' => '',
                'Manager' => '',
                'Contributor' => '',
                'Analyst' => '',
                'Other' => '',
            ],
            'industry-select' => [
                '' => '',
                'Marketing and Advertising' => '',
                'Software and Internet' => '',
                'Financial Services' => '',
                'Business Services' => '',
                'Media and Entertainment' => '',
                'Education' => '',
                'E-commerce' => '',
                'Consumer Products' => '',
                'Consumer Services' => '',
                'Healthcare and Pharmaceuticals' => '',
                'Real Estate' => '',
                'Manufacturing' => '',
                'Government and Nonprofits' => '',
                'Other' => '',
                'Automotive' => '',
                'Energy and Utilities' => '',
                'Travel, Recreation & Leisure' => '',
                'Telecommunications' => '',
                'Computer Software' => '',
                'Retail' => '',
                'Insurance' => '',
            ],
            'use-case-select' => [
                '' => '',
                'Build pages quickly' => '',
                'Increase conversions' => '',
                'Validate an idea' => '',
                'Create temporary website' => '',
                'Expand my usage' => '',
                'Other' => '',
            ],
            'marketing-channel-select' => [
                '' => '',
                'Email' => '',
                'Facebook Ads' => '',
                'Google Ads' => '',
                'LinkedIn Ads' => '',
                'Pinterest Ads' => '',
                'Bing Ads' => '',
                'Twitter Ads' => '',
                'Other' => '',
            ],
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
            'phoneNumber' => Data::_stringFromPost('phone-number'),
            'message' => Data::_stringFromPost('message'),
            'company' => Data::_stringFromPost('company'),
            'companySize' => Data::_stringFromPost('company-size-select'),
            'jobTitle' => Data::_stringFromPost('job-select'),
            'seniority' => Data::_stringFromPost('seniority-select'),
            'industry' => Data::_stringFromPost('industry-select'),
            'useCase' => Data::_stringFromPost('use-case-select'),
            'marketingChannel' => Data::_stringFromPost('marketing-channel-select'),
        ];
    }

    /**
     * Prepare submitted data by user to show them in Form UI
     * (we need to have information about what fields where selected etc)
     */
    public function getOldData(): array
    {
        $formFields = $this->getFields();

        $formFields['first-name'] = Data::_stringFromPost('first-name');
        $formFields['last-name'] = Data::_stringFromPost('last-name');
        $formFields['email'] = Data::_stringFromPost('email');
        $formFields['phone-number'] = Data::_stringFromPost('phone-number');
        $formFields['message'] = Data::_stringFromPost('message');
        $formFields['company'] = Data::_stringFromPost('company');
        $formFields['company-size-select'][Data::_stringFromPost('company-size-select')] = 'selected';
        $formFields['job-select'][Data::_stringFromPost('job-select')] = 'selected';
        $formFields['seniority-select'][Data::_stringFromPost('seniority-select')] = 'selected';
        $formFields['industry-select'][Data::_stringFromPost('industry-select')] = 'selected';
        $formFields['use-case-select'][Data::_stringFromPost('use-case-select')] = 'selected';
        $formFields['marketing-channel-select'][Data::_stringFromPost('marketing-channel-select')] = 'selected';

        return $formFields;
    }

    public function getRequiredFields(): array {
        return [
            'first-name',
            'last-name',
            'email',
            'phone-number',
            'company',
            'company-size-select',
            'job-select',
            'seniority-select',
            'industry-select',
            'use-case-select',
            'marketing-channel-select',
        ];
    }

    public function prepareHubspotLeadFromFormData(): object
    {
        $formData = $this->getData();

        return (object)[
            'firstname' => $formData['firstName'],
            'lastname' => $formData['lastName'],
            'email' => $formData['email'],
            'phone' => $formData['phoneNumber'],
            'temp_comments' => $formData['message'],
            'company' => $formData['company'],
            'company_size' => $formData['companySize'],
            'jobtitle' => $formData['jobTitle'],
            'seniority' => $formData['seniority'],
            'industry' => $formData['industry'],
            'primary_marketing_channel' => $formData['marketingChannel'],
            'primary_use_case' => $formData['useCase']
        ];
    }
}
