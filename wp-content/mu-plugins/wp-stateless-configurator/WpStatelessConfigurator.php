<?php

namespace WpStatelessConfigurator;

use Instapage\Classes\Environment;

class WpStatelessConfigurator
{
    /** @var Environment */
    private $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function setConfigurationBasedOnEnvironment()
    {
        if ($this->environment->isItLive()) {
            if (!defined('WP_STATELESS_MEDIA_BUCKET')) {
                define('WP_STATELESS_MEDIA_BUCKET', 'website-production');
            }
        } else {
            if (!defined('WP_STATELESS_MEDIA_BUCKET')) {
                define('WP_STATELESS_MEDIA_BUCKET', 'website-development');
            }
            if (!defined('WP_STATELESS_MEDIA_DELETE_REMOTE')) {
                define('WP_STATELESS_MEDIA_DELETE_REMOTE', false);
            }
        }
    }
}
