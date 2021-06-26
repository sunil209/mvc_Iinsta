<?php

require_once(ABSPATH . '/wp-content/themes/instapagev3/pre-wp-actions/autoloader.php');
require_once(__DIR__ . '/WpStatelessConfigurator.php');

use Instapage\Classes\Environment;
use WpStatelessConfigurator\WpStatelessConfigurator;

$environment = new Environment($_SERVER);
$wpStatlessConfigurator = new WpStatelessConfigurator($environment);
$wpStatlessConfigurator->setConfigurationBasedOnEnvironment();

