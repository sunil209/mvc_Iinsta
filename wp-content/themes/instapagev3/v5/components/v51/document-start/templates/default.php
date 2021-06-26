<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $templateClass     CSS class for <body> element.
 * @param string $headerImage       Url of image to be used instead of css class
 * @param array  $attributes        Associative array of attributes
 */
use Instapage\Helpers\HtmlHelper;
use Instapage\Helpers\Segment\SegmentHelper;
use Instapage\Classes\Component;

$templateClass = (!empty($templateClass)) ? $templateClass : getAcfVar('template_class', '', $params['contextID']);
$headerImage = (!empty($headerImage)) ? $headerImage : getAcfVar('header_image', '', $params['contextID']);
$ampUrl = getV5AmpUrl();
$relPrevLink = getSeoPageNeighbourUrl('prev');
$relNextLink = getSeoPageNeighbourUrl('next');

global $amp;

$ampEnabled = $amp->hasPageEnabledAmp();
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <?php $favicon_version_sufix = '?v=2'; ?>
  <meta charset="utf-8">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="norton-safeweb-site-verification" content="o2k5lbovscw86j47m5gi68h7x63fcmy178px1xoq0pvie-9pqufkoxsme2qth7a7uk8prdw2axgq2vn-bm0dalbw5d3-sj-5tpw6htwjeqtxj1ml7jmqafpu5pbb3ohl" />
  <meta property="fb:pages" content="207291729312530" />
  <meta name="p:domain_verify" content="75193bfcd48de4acbfcde334f33b88b8"/>
  <meta name="google-site-verification" content="OFv3QGkmym9h-FDLmQ1StF-pzvMnXPaBtTLqkE7tmiw" />  
  <meta name="ampenabled" content="<?= (int) $ampEnabled; ?>">
  <script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "Organization",
    "name": "Instapage",
    "url": "https://instapage.com",
    "logo": "https://instapage.com/wp-content/themes/instapagev3/v5/assets/images/logo.png",
    "sameAs": [
      "https://www.facebook.com/Instapageapp",
      "https://twitter.com/Instapage",
      "https://www.linkedin.com/company/instapage",
      "https://www.youtube.com/c/instapage",
      "https://www.instagram.com/instapage.team/"
    ]
  }
  </script>
  <?php require_once(get_template_directory() . '/assets/scripts/favicon-meta.php'); ?>
  <script type="text/javascript">
    var template_name = 'instapage';
    var font_awesome_path = '<?= get_template_directory_uri(); ?>/assets/css/font-awesome.min.css';
  </script>
  <?php wp_head(); ?>
  <title><?php wp_title('', true, 'right'); ?></title>
  <?php Component::render('v51/rel-metatag', 'custom-field-based'); ?>
  <?php Component::render('v51/stage-metatag'); ?>
  <?php Component::render('v51/categories-metatag'); ?>
  <?php if (!empty($ampUrl)): ?>
    <?php Component::render('v51/rel-metatag', ['type' => 'amphtml', 'url' => $ampUrl]); ?>
  <?php endif; ?>
  <?php
    if ($relPrevLink !== null):
      Component::render('v51/rel-metatag', ['type' => 'prev', 'url' => $relPrevLink]);
    endif;
    if ($relNextLink !== null):
      Component::render('v51/rel-metatag', ['type' => 'next', 'url' => $relNextLink]);
    endif;
  ?>
  <link rel="preconnect" href="https://api.segment.io" crossorigin>
  <link rel="preconnect" href="https://cdn.segment.com" crossorigin>
  <link rel="preconnect" href="https://s3.amazonaws.com" crossorigin>
  <link rel="preconnect" href="https://ajax.googleapis.com" crossorigin>
  <link rel="preconnect" href="https://storage.googleapis.com" crossorigin>
  <link rel="preconnect" href="https://js.intercomcdn.com" crossorigin>
  <!-- Start of Async Drift Code -->
<script>
"use strict";

function LoadDriftWidget() {
  var t = window.driftt = window.drift = window.driftt || [];
  if (!t.init) {
    if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
    t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ], 
    t.factory = function(e) {
      return function() {
        var n = Array.prototype.slice.call(arguments);
        return n.unshift(e), t.push(n), t;
      };
    }, t.methods.forEach(function(e) {
      t[e] = t.factory(e);
    }), t.load = function(t) {
      var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
      o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
      var i = document.getElementsByTagName("script")[0];
      i.parentNode.insertBefore(o, i);
    };
  }
  drift.SNIPPET_VERSION = '0.3.1';
  drift.load('9cfm4m5ykpf9');
};

//load after waiting 5000 milliseconds, 5 seconds
setTimeout(function(){ 
     LoadDriftWidget(); 
}, 5000)

</script>
<!-- End of Async Drift Code -->
<meta name="facebook-domain-verification" content="sfywk2a0i5pasmsqc8w1oqbn92ukzq" />

</head>
<body <?php body_class($templateClass); ?> <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
  <?php SegmentHelper::renderSegmentSnippet();
  Component::render('messagebar'); ?>
