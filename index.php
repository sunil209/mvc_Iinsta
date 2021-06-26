<?php

require __DIR__ . '/vendor/autoload.php';

define('WP_USE_THEMES', true);
define('INSTAPAGEDEV_IP', '104.197.45.98');
define('DEFAULT_SITEURL', 'https://instapage.com');

$serverIp = isset($_SERVER['SERVER_ADDR']) ? trim($_SERVER['SERVER_ADDR']) : '';
$hostname = gethostname();
$devPattern1 = '/^10\.1\.1\.[0-9]{1,3}$/';
$devPattern2 = '/^192\.168\.16\.[0-9]{1,3}$/';
$localhostIp = '127.0.0.1';
$devIpArray = [INSTAPAGEDEV_IP, $localhostIp];
$is404 = false;

require_once(dirname(__FILE__) . '/wp-content/themes/instapagev3/pre-wp-actions/autoloader.php');
use \Instapage\Classes\AbTesting\Campaign;
use \Instapage\Modules\FastHttpHandler\FastHttpHandler;

// performs necessary redirects
$instapageGoogleOptimizeCampaign = new Campaign();
$fastHttpHandler = new FastHttpHandler();
$handleResult = $fastHttpHandler->handle($_SERVER['REQUEST_METHOD'], $_SERVER['HTTP_HOST']);

// Request was handled by fast router, abort
if ($handleResult) {
    exit;
}

if (
    $serverIp === $localhostIp ||
    preg_match($devPattern1, $serverIp) ||
    preg_match($devPattern2, $serverIp) ||
    $_SERVER['HTTP_HOST'] === 'localhost'
) {
    define('IS_DEV', true);
    define('IS_INSTOK', true);
} else if (in_array($serverIp, $devIpArray) || $hostname === 'instapage-dev-1') {
    // This can be removed as soon as instapagedev.com is terminated
    define('IS_DEV', true);
    define('IS_INSTAPAGEDEV', true);
}

if (
    !extension_loaded('memcache') ||
    (defined('IS_DEV') && IS_DEV)
) {
    $contents = '';
} else {
    require( 'wp-rapid-cache.php' );
    $rapidCache = new RapidCache();
    $contents = $rapidCache->getContents();
}

if (empty($contents)) {
    ob_start();

    //Loads the WordPress Environment and Template
    require(dirname( __FILE__ ) . '/wp-blog-header.php');

    // We don't need further manipulations if it's content sensitive format
    $parts = explode('.', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (in_array(end($parts), ['js', 'xml'])) {
        exit($contents);
    }

    //There is no need to check if we are trying to cache a landing page. CMS plugin displays a HTML from Enterprise and performs "exit". The code below doesn't execute for landing pages.
    $serverName = (defined('WP_ADD_SERVER_NAME') && WP_ADD_SERVER_NAME && defined('WP_SERVER_NAME')) ? WP_SERVER_NAME : '';
    $contents = ob_get_contents();
    ob_end_clean();

    if ($serverName) {
        $contents .= '<!-- ' . $serverName . ' -->';
    }

    if (function_exists('is_404') && is_404()) {
        $is404 = true;
    }

    $contents = preg_replace_callback(
        '#\<a(.*?)target\=("|\')_blank(?:"|\')(.*?)\>#si',
        function($matches) {
            return (stripos($matches[0], ' rel=') !== false) ?
                preg_replace('#rel\=("|\')#i', 'rel=${1}noopener noreferrer ', $matches[0]) :
                "<a{$matches[1]}target={$matches[2]}_blank{$matches[2]}{$matches[3]} rel={$matches[2]}noopener noreferrer{$matches[2]}>";
        },
        $contents
    );

    if (defined('WP_SITEURL') && defined('DEFAULT_SITEURL')) {
        $contents = str_replace(DEFAULT_SITEURL, WP_SITEURL, $contents);
    }

    // applies necessary JS code at the end of HTML document
    $instapageGoogleOptimizeCampaign->applyGoogleOptimizeScripts($contents);

    echo $contents . '<!-- not cached -->';

    if ((!defined('IS_DEV') || !IS_DEV) && !$is404) {
        $rapidCache->saveContents($contents);
    }
} else {
    echo $contents . '<!-- cached -->';
}
