<?php
namespace Instapage\Components\v70\Contact;

use Instapage\Models\Component;

/**
 * Model for v7 address component
 *
 */
class ContactModel extends Component
{
    public function getPageTitle() : string
    {
        return (string) get_the_title();
    }

    public function getEmail() : string
    {
        return (string) get_field('email', $this->isGlobalAcf());
    }

    public function getAddress() : array
    {
        return (array) get_field('postal_address', $this->isGlobalAcf());
    }

    /**
     * Check if template should load data from "Default component values" site for CTA section in "Custom site config"
     *
     * @return string|bool
     */
    private function isGlobalAcf()
    {
        return (bool) get_field('contact_is_global', $this->contextID ?? false) === true ? 'option' : $this->contextID ?? false;
    }

    /**
    * Method from abstract class telling which info model can generate
    *
    * @return array
    */
    public function getParamsListToInject(): array
    {
        return [
            'pageTitle',
            'email',
            'address'
        ];
    }
}
