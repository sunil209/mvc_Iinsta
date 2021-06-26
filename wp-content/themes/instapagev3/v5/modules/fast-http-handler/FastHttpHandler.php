<?php

namespace Instapage\Modules\FastHttpHandler;

/**
 * Class FastHttpHandler is responsible for fast handling of OPTIONS/HEAD HTTP Request without
 * firing whole WordPress ecosystem
 *
 * @package Instapage\Modules\FastHttpHandler
 */
class FastHttpHandler
{
    public function handle(string $httpMethod, string $host): bool
    {
        if (headers_sent()) {
            error_log('Headers already sent, FastHttpHandler couldn\'t effectively handle request.');
            return false;
        }

        switch ($httpMethod) {
            case AllowedMethods::OPTIONS:
                $this->optionsHandler($host);
                break;
            case AllowedMethods::HEAD:
                $this->headHandler($host);
                break;
            default:
                return false;
        }

        return true;
    }

    private function optionsHandler(string $host): void
    {
        header('Allow: OPTIONS, GET, HEAD, POST');
        $this->commonResponseHeaders($host);
    }

    private function headHandler(string $host): void
    {
        $this->commonResponseHeaders($host);
    }

    private function commonResponseHeaders(string $host): void
    {
        header('Cache-control: public, must-revalidate');
        header('Origin: ' . $host);
    }
}
