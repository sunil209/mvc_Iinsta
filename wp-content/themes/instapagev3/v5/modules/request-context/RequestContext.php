<?php

namespace Instapage\Modules\RequestContext;

class RequestContext
{
    private $serverInformation;

    public function __construct(array $serverInformation)
    {
        $this->serverInformation = $serverInformation;
    }

    public function getUserIp(): ?string
    {
        $addressHeaders = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];

        foreach ($addressHeaders as $addressHeader) {
            if (empty($this->serverInformation[$addressHeader])) {
                continue;
            }

            $ipAddresses = explode(',', $this->serverInformation[$addressHeader]);
            return trim($ipAddresses[0]);
        }

        return null;
    }

    public function getUserAgent(): string
    {
        return $this->serverInformation['HTTP_USER_AGENT'] ?? '';
    }

    public function getReferer(): string
    {
        return $this->serverInformation['HTTP_REFERER'] ?? '';
    }

    public function getPageName(): string
    {
        return get_the_title();
    }

    public function getPath(): string
    {
        return $this->serverInformation['REQUEST_URI'] ?? '';
    }

    public function getPageUri(): string
    {
        $requestUri = $this->serverInformation['REQUEST_URI'] ?? '';
        $hostName = $this->serverInformation['HTTP_HOST'] ?? '';
        $httpProtocol = $this->serverInformation['HTTPS'] === 'on' ? "https" : "http";

        return $httpProtocol . '://' . $hostName . $requestUri;
    }
}
