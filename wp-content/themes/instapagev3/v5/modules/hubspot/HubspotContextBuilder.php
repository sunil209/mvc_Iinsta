<?php

namespace Instapage\Modules\Hubspot;

use Instapage\Configs\HubspotConfiguration;
use Instapage\Modules\RequestContext\RequestContext;

class HubspotContextBuilder
{
    private $requestContext;
    private $cookies;

    public function __construct(RequestContext $requestContext, array $cookies)
    {
        $this->requestContext = $requestContext;
        $this->cookies = $cookies;
    }

    /**
     * @see https://developers.hubspot.com/docs/methods/forms/submit_form format of hubspot lead context description
     */
    public function build(): array
    {
        $context = [
            'hutk' => $this->getHubspotUserToken(),
            'ipAddress' => $this->requestContext->getUserIp(),
            'pageName' => $this->requestContext->getPageName(),
            'pageUri' => $this->requestContext->getPageUri(),
        ];

        // removing blank, null, false, 0 (zero) values
        // as Hubspot API rejects leads with any context with passed empty values
        return array_filter($context);
    }

    protected function getHubspotUserToken(): string
    {
        return $this->cookies[HubspotConfiguration::HUBSPOT_USER_TOKEN_COOKIE_NAME] ?? '';
    }
}
