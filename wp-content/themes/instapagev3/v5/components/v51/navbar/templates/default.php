<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param bool   $isSticky          Should navbar be sticky
 * @param string $desktopNavbarMenu v51/navbar-menu for desktop
 * @param string $mobilepNavbarMenu v51/navbar-menu for mobile
 * @param string $menuClass         navbar class
 * @param array  $attributes        Associative array of attributes
 * @param string $mobileClass       Class for mobile nav container
 *
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;

$desktopNavbarMenu = (!empty($desktopNavbarMenu)) ? $desktopNavbarMenu : Component::fetch(
    'v51/navbar-menu',
    ['btnClass' => 'btn-white', 'items' => getV5Menu('v5-top-menu'), 'contextID' => $contextID]
);
$mobileNavbarMenu = (!empty($mobileNavbarMenu)) ? $mobileNavbarMenu : Component::fetch(
    'v51/navbar-menu',
    'mobile',
    ['items' => getV5Menu('v5-top-menu')]
);
$isNavigationHidden = get_field('is_navigation_hidden', $contextID ?? false) === true;
$dataState = isset($isSticky) && !$isNavigationHidden ? 'sticky' : '';
?>

<!---- NAVBAR ---->
<nav
    class="navbar navbar-desktop
        <?= $menuClass ?? '' ?>
        <?= (!(isset($isSticky)) && !$isNavigationHidden) ? 'js-navbar' : ''; ?>"
    data-state="<?= $dataState; ?>"
>
    <div class="navbar-content v7-content">
        <div class="navbar-home-link">
            <a href="<?= get_home_url(); ?>"><?php HtmlHelper::renderLogo(); ?></a>
        </div>
        <!-- NAVBAR MENU -->
        <?= $desktopNavbarMenu; ?>
    </div>
</nav>
<!---- NAVBAR MOBILE ---->
<!-- MAIN MENU WITH HAMBURGER -->
<nav
    class="navbar navbar-mobile navbar-mobile-bar js-navbar-mobile
        <?= $menuClass ?? '' ?>
        <?= (!(isset($isSticky)) && !$isNavigationHidden) ? 'js-navbar' : ''; ?>"
    data-state="<?= $dataState; ?>"
>
    <!-- NAVBAR MOBILE HEADER -->
    <header class="navbar-content">
        <a href="<?= get_home_url(); ?>"><?php HtmlHelper::renderLogo(); ?></a>
        <?php if (!$isNavigationHidden): ?>
            <div class="icon-hamburger js-navbar-hamburger">
                <div class="icon-hamburger-lines"></div>
            </div>
        <?php endif; ?>
    </header>
</nav>
<?php if (!$isNavigationHidden): ?>
    <!-- EXPANDABLE MOBILE MENU -->
    <nav
        class="navbar navbar-mobile navbar-mobile-expandable
            <?= $menuClass ?? '' ?>"
        data-state="open"
    >
        <!-- NAVBAR MOBILE HEADER -->
        <header class="navbar-content-expand">
            <div class="icon-hamburger js-navbar-hamburger">
                <div class="icon-hamburger-lines"></div>
            </div>
        </header>
        <!-- NAVBAR MOBILE MENU -->
        <?= $mobileNavbarMenu; ?>
    </nav>
<?php endif; ?>
<!-- DIM -->
<div class="dim" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>></div>
