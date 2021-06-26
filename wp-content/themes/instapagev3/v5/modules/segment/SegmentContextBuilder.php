<?php

namespace Instapage\Modules\Segment;

use Instapage\Modules\RequestContext\RequestContext;

class SegmentContextBuilder
{
    private $requestContext;
    private $cookies;

    public function __construct(RequestContext $requestContext, array $cookies)
    {
        $this->requestContext = $requestContext;
        $this->cookies = $cookies;
    }

    public function build(): array
    {
        return [
            'user_agent' => $this->requestContext->getUserAgent(),
            'ip' => $this->requestContext->getUserIp(),
            'page' => $this->fetchPageContext(),
        ];
    }

    protected function fetchPageContext(): array
    {
        return [
            'path' => $this->requestContext->getPath(),
            "referrer" => $this->requestContext->getReferer(),
            "search" => "",
            "title" => get_the_title(),
            "url" => $this->requestContext->getPageName()
        ];
    }

    public function getGoogleAnalyticsClientId(): ?string
    {
        $clientID = null;
        // A Google Analytics Universal cookie will look like this:
        // _ga=GA1.2.1033501218.1368477899;
        // The clientId is this part: 1033501218.1368477899
        $GACookie = $this->cookies['_ga'] ?? '';
        $GACookieExploded = array_reverse(explode('.', $GACookie));

        if (count($GACookieExploded) > 2) {
            $clientID =  $GACookieExploded[1] . '.' . $GACookieExploded[0];
        }

        return $clientID;
    }
}
