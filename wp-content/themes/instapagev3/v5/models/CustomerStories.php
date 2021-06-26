<?php
namespace Instapage\Models;

/**
 * Model for /customer-stories page
 */
class CustomerStories extends Root
{
    /**
     * @var string $postType Holds information about what postType should be used with this model
     */
    public $postType = 'customer-stories';

    /**
     * Returns ID of page from which ACF fields for header section should be taken from
     * @return int
     */
    public function getContextID()
    {
        return get_page_by_path('static-customer-stories');
    }

    /**
     * Gets company data
     * @return array
     */
    public function getCompanyData()
    {
        return array_combine(
            ['companyLogo', 'companyLogoRetina', 'companyName', 'companyUrl', 'companyLocation', 'companyEmployees'],
            getAcfVars(
                ['company_logo', 'company_logo_retina', 'company_name', 'company_url', 'company_location', 'company_employees'],
                ['', '', '', '', '', '']
            )
        );
    }
}
