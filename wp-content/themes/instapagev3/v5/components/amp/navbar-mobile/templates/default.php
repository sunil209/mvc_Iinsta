<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $templateClass     CSS class for <body> element.
 * @param string $headerImage       Url of image to be used instead of css class
 * @param array  $attributes        Associative array of attributes
 * @param bool   $isSticky          Should navbar be sticky
 *
 * @param array  $components       - array related to AMP specific elements:
 *   ['analytics']   - (bool) should the `analytics` script be included
 *   ['socialShare'] - (bool) should the `social share` script be included
 *   ['form']        - (bool) should the `form` script be included
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;

$templateClass = ((isset($templateClass)) && (!empty($templateClass))) ? $templateClass : getAcfVar('template_class', '', $params['contextID']);
$headerImage = ((isset($headerImage)) && (!empty($headerImage))) ? $headerImage : getAcfVar('header_image', '', $params['contextID']);

$analytics = (isset($params['components']['analytics'])) ? $params['components']['analytics'] : false;
$socialShare = (isset($params['components']['socialShare'])) ? $params['components']['socialShare'] : false;
$form = (isset($params['components']['form'])) ? $params['components']['form'] : false;
$navigation = (isset($navigation)) ? (bool) $navigation : true;
$items = getV5Menu('v5-top-menu');
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
  <nav class="navbar navbar-mobile navbar-mobile-bar js-navbar-mobile" [class]="app.nav.state[app.navState]" data-state="<?= isset($isSticky) ? 'sticky' : ''; ?>">
    <header class="navbar-content">
      <a href="<?= get_home_url(); ?>"><?php HtmlHelper::renderLogo(); ?></a>
      <div class="icon-hamburger js-navbar-hamburger" tabindex="1" role="button" on="tap:AMP.setState({ app: { navState: 'open' } })">
        <div class="icon-hamburger-lines"></div>
      </div>
    </header>
  </nav>
  <nav class="navbar navbar-mobile navbar-mobile-expandable" data-state="open <?= isset($isSticky) ? 'sticky' : ''; ?>">
    <header class="navbar-content">
      <a href="<?= get_home_url(); ?>"><?php HtmlHelper::renderLogo(); ?></a>
      <div class="icon-hamburger js-navbar-hamburger" data-state="active" tabindex="1" role="button" on="tap:AMP.setState({ app: { navState: 'close' } })">
        <div class="icon-hamburger-lines"></div>
      </div>
    </header>
    <amp-accordion disable-session-states>
       <?php foreach ($items as $item): ?>
        <?php if ((is_array($item['child_nodes'])) && (!empty($item['child_nodes']))): ?>
          <section class="expand-item">
            <!-- EXPANDABLE OPTION HEADER -->
            <header class="expand-trigger navbar-menu-option amp-menu-option">
              <?php if (!empty($item['url'])): ?>
                <a href="<?= $item['url']; ?>"><?= __($item['title']); ?></a><i class="material-icons expand-icon">keyboard_arrow_down</i>
              <?php else: ?>
                <span><?= __($item['title']); ?></span><i class="material-icons expand-icon amp-expand-icon">keyboard_arrow_down</i>
              <?php endif; ?>
            </header>
            <!-- EXPANDABLE MENU -->
            <div class="expand-content">
              <?php if (getLayout($item) === 'single'): ?>
                <?php foreach ($item['child_nodes'] as $item): ?>
                  <a href="<?= $item['url']; ?>" class="navbar-submenu-option <?= implode(' ', $item['classes']); ?>"><?= __($item['title']); ?></a>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="navbar-submenu-deeper">
                  <?php foreach ($item['child_nodes'] as $item): ?>
                    <span class="navbar-submenu-title"><?= __($item['title']); ?></span>
                    <?php if ((is_array($item['child_nodes'])) && (!empty($item['child_nodes']))): ?>
                      <?php foreach ($item['child_nodes'] as $item): ?>
                        <a href="<?= $item['url']; ?>" class="navbar-submenu-option"><?= __($item['title']); ?></a>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </section>
          <?php endif; ?>
      <?php endforeach; ?>
    </amp-accordion>
    <?php if (in_array('btn', $item['classes'])): ?>
    <div class="navbar-menu-option">
      <?php Component::render('v51/button', ['text' => __($item['title']), 'url' => $item['url'], 'class' => 'btn is-huge btn-cta']); ?>
    </div>
    <?php else: ?>
      <?php Component::render('v51/button', ['text' => __($item['title']), 'url' => $item['url'], 'class' => 'navbar-menu-option']); ?>
    <?php endif; ?>
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
