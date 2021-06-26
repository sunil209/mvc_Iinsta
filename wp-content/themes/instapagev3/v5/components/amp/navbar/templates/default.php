<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $navbarMenu        v51/navbar-menu for mobile
 * @param array  $attributes        Associative array of attributes
 *
 * @param array  $components        Array related to AMP specific elements:
 *               bool analytics     Should the `analytics` script be included
 *               bool socialShare   Should the `social share` script be included
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;

$navbarMenu = ((isset($navbarMenu)) && (!empty($navbarMenu))) ? $navbarMenu : Component::fetch('v51/navbar-menu', 'mobile', ['items' => getV5Menu('v5-top-menu')]);
$analytics = (isset($params['components']['analytics'])) ? $params['components']['analytics'] : false;
$socialShare = (isset($params['components']['socialShare'])) ? $params['components']['socialShare'] : false;
$navigation = (isset($navigation)) ? (bool) $navigation : true;
Component::render('amp/segment', ['analytics' => $analytics]);
?>
<?php if ($socialShare): ?>
  <nav class="navbar-social">
    <amp-social-share layout="flex-item" height="50" type="bufferapp" data-share-endpoint="https://bufferapp.com/add" data-param-url="CANONICAL_URL" data-param-text="TITLE">
      <svg class="buffer-icon" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.5 26.03">
        <title>Buffer</title>
        <path class="cls-1" fill="#fff" d="M.29,6.63,12,12.29a.45.45,0,0,0,.42,0L24.21,6.63a.48.48,0,0,0,0-.88L12.46.05a.45.45,0,0,0-.42,0L.29,5.72A.5.5,0,0,0,.29,6.63Z"/>
        <path class="cls-1" fill="#fff" d="M.29,13.49,12,19.15a.45.45,0,0,0,.42,0l11.75-5.66a.48.48,0,0,0,0-.88l-2.47-1.2-7.87,3.77a3.75,3.75,0,0,1-1.62.35,4.2,4.2,0,0,1-1.62-.35l-7.88-3.8L.29,12.57A.51.51,0,0,0,.29,13.49Z"/>
        <path class="cls-1" fill="#fff" d="M24.21,19.43l-2.47-1.19L13.87,22a3.62,3.62,0,0,1-1.62.36A4.21,4.21,0,0,1,10.63,22L2.75,18.24.29,19.43a.48.48,0,0,0,0,.88L12,26a.45.45,0,0,0,.42,0l11.75-5.62A.51.51,0,0,0,24.21,19.43Z"/>
      </svg>
    </amp-social-share>
    <amp-social-share layout="flex-item" height="50" type="linkedin"></amp-social-share>
    <amp-social-share layout="flex-item" height="50" type="twitter"></amp-social-share>
    <amp-social-share layout="flex-item" height="50" type="facebook" data-param-app_id="254325784911610"></amp-social-share>
  </nav>
<?php endif; ?>
<?php if ($navigation): ?>
  <nav class="navbar navbar-mobile navbar-mobile-bar js-navbar-mobile" [class]="app.nav.state[app.navState]">
    <header class="navbar-content">
      <a href="<?= get_home_url(); ?>"><?php HtmlHelper::renderLogo(); ?></a>
      <div class="icon-hamburger js-navbar-hamburger" tabindex="1" role="button" on="tap:AMP.setState({ app: { navState: 'open' } })">
        <div class="icon-hamburger-lines"></div>
      </div>
    </header>
  </nav>
  <nav class="navbar navbar-mobile navbar-mobile-expandable" data-state="open">
    <header class="navbar-content">
      <a href="<?= get_home_url(); ?>"><?php HtmlHelper::renderLogo(); ?></a>
      <div class="icon-hamburger js-navbar-hamburger" data-state="active" tabindex="1" role="button" on="tap:AMP.setState({ app: { navState: 'close' } })">
        <div class="icon-hamburger-lines"></div>
      </div>
    </header>
    <?= $navbarMenu; ?>
  </nav>
  <amp-state id="app">
    <script type="application/json">
      {
        "navState": "close",
        "nav": {
          "state": {
            "close": "navbar navbar-mobile navbar-mobile-bar js-navbar-mobile data-state-closed",
            "open": "navbar navbar-mobile navbar-mobile-bar js-navbar-mobile data-state-open"
          }
        }
      }
    </script>
  </amp-state>
<?php endif; ?>
