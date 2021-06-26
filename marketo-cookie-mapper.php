<?php

require_once __DIR__ . '/wp-content/themes/instapagev3/v5/helpers/StringHelper.php';

use Instapage\Helpers\StringHelper;

define('MARKETO_COOKIE_NAME', '_mkto_trk');
/**
 * Decide from which domains we should map marketo cookies
 */
define('VALID_REFERER', 'postclick.com');

/**
 * We use set raw cookie inside because marketo cookie value has some characters wich are changes by urlencode
 * function so Marketo JS treats it as different value (setcookie use urlencode function).
 *
 * NOTE:    Header injection was taken into consideration, by default setrawcookie funciton rejects any invalid
 *          characters which can lead to header injection attack: `,;<space>\t\r\n\013\014`
 *
 * @param string $base64MarketoCookieValue
 */
function setMarketoCookie(string $base64MarketoCookieValue): void
{
    if (empty($base64MarketoCookieValue)) {
        return;
    }

    $marketoCookieValue = base64_decode($base64MarketoCookieValue);

    if ($marketoCookieValue === false) {
        return;
    }

    setrawcookie(MARKETO_COOKIE_NAME, $marketoCookieValue, time() + 3600);
}


/**
 * Check if marketo cookie mapping should take place:
 * - check if marketo cookie is not set (we don't allow cookie overwriting)
 * - check if referer is proper, we allow only our domains to map cookies over
 *
 * @return bool
 */
function shouldBeMapped(): bool
{
    return !isset($_COOKIE[MARKETO_COOKIE_NAME])
        && StringHelper::checkIfRefererIsValid($_SERVER['HTTP_REFERER'] ?? '', VALID_REFERER);
}

if (shouldBeMapped()) {
    setMarketoCookie($_GET['value'] ?? '');
}
