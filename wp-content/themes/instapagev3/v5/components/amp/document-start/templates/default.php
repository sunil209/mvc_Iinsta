<?php
/**
 * Template file. Template params are stored in $params array
 * $templateClass    - CSS class for <body> element.
 * $attributes       - associative array of attributes
 * $cssFonts         - (array) an array of font URIs from whitelisted providers like Google Font
 * $cssFile          - (string) CSS filename
 * $structuredData   - array of meta data used by search engines like Google
 *  * $components       - array related to AMP specific elements:
 *   ['iframe']      - (bool) should the `iframe` script be included
 *   ['analytics']   - (bool) should the `analytics` script be included
 *   ['socialShare'] - (bool) should the `social share` script be included
 *   ['form']        - (bool) should the `form` script be included
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;

$headerImage = ((isset($headerImage)) && (!empty($headerImage))) ? $headerImage : getAcfVar('header_image', '', $params['contextID']);
$templateClass = ((isset($templateClass)) && (!empty($templateClass))) ? $templateClass : getAcfVar('template_class', '', $params['contextID']);
$iframe = (isset($params['components']['iframe'])) ? $params['components']['iframe'] : false;
$analytics = (isset($params['components']['analytics'])) ? $params['components']['analytics'] : false;
$accordion = $components['accordion'] ?? false;
$ampVideo = $components['ampVideo'] ?? false;
$socialShare = (isset($params['components']['socialShare'])) ? $params['components']['socialShare'] : false;
$form = (isset($params['components']['form'])) ? $params['components']['form'] : false;
$cssFonts = (isset($cssFonts) && !empty($cssFonts)) ? $cssFonts : [];
$cssFile = (isset($cssFile) && !empty($cssFile)) ? $cssFile : 'amp.min.css';
$structuredData = (isset($structuredData) && !empty($structuredData)) ? $structuredData : false;
$canonical = !empty($canonical) ? $canonical : get_permalink();
$bind = (isset($params['components']['bind'])) ? $params['components']['bind'] : false;
?>

<!doctype html>
<html ⚡ <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <title><?php wp_title('', true, 'right'); ?></title>
    <meta name="description" content="<?= esc_attr($description); ?>"/>
    <?= $ogImage; ?>
    <link rel="canonical" href="<?= $canonical; ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="norton-safeweb-site-verification" content="o2k5lbovscw86j47m5gi68h7x63fcmy178px1xoq0pvie-9pqufkoxsme2qth7a7uk8prdw2axgq2vn-bm0dalbw5d3-sj-5tpw6htwjeqtxj1ml7jmqafpu5pbb3ohl" />
    <meta property="fb:pages" content="207291729312530" />

    <?php Component::render('v51/categories-metatag'); ?>

    <?php if ($structuredData): ?>
      <script type="application/ld+json">
        {
          "@context": "http://schema.org/",
          "@type": "Article",
          "publisher": {
            "@type": "Organization",
            "name": "Instapage",
            "sameAs": [
              "https://www.facebook.com/Instapageapp",
              "https://twitter.com/Instapage",
              "https://www.linkedin.com/company/instapage",
              "https://www.youtube.com/c/instapage",
              "https://www.instagram.com/instapage.team/"
            ],
            "logo": {
              "@type": "ImageObject",
              "url": "<?= $structuredData['logo']; ?>",
              "width": {
                "@type": "Intangible",
                "name": <?= $structuredData['logoWidth']; ?>
              },
              "height": {
                "@type": "Intangible",
                "name": <?= $structuredData['logoHeight']; ?>
              }
            }
          },
          "author": {
            "@type": "Person",
            "name": "<?= $structuredData['author']; ?>"
          },
          "datePublished": "<?= $structuredData['datePublished']; ?>",
          "dateModified": "<?= $structuredData['dateModified']; ?>",
          "headline": "<?= $structuredData['headline']; ?>",
          "image": {
            "@type": "ImageObject",
            "url": "<?= $structuredData['image']; ?>",
            "width": {
              "@type": "Intangible",
              "name": <?= $structuredData['imageWidth']; ?>
            },
            "height": {
              "@type": "Intangible",
              "name": <?= $structuredData['imageHeight']; ?>
            }
          },
          "mainEntityOfPage": {
            "@type": "WebPage"
          }
        }
      </script>
    <?php endif; ?>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <?php if ($analytics): ?>
      <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <?php endif; ?>
    <?php if ($iframe): ?>
      <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
    <?php endif; ?>
    <?php if ($socialShare): ?>
      <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    <?php endif; ?>
    <?php if ($form): ?>
      <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
    <?php endif; ?>
    <?php if ($bind): ?>
      <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>
    <?php endif; ?>
    <?php if ($accordion): ?>
      <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
    <?php endif; ?>
    <?php if ($ampVideo): ?>
      <script async custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script>
    <?php endif; ?>
    <?php foreach ($cssFonts as $cssFont): ?>
      <link href="<?= $cssFont; ?>" rel="stylesheet">
    <?php endforeach; ?>
    <style amp-custom>
      .cls-1 { fill: #fff; fill-rule: evenodd; }
      <?php if ((isset($headerImage)) && (!empty($headerImage))): ?>
        .header-section{background-image:url("<?= $headerImage; ?>");}
      <?php endif; ?>
      <?php replaceRelativePaths([[$cssFile, 'v5-template']], false); ?>
    </style>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
  </head>
  <body <?php body_class($templateClass); ?> <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?> id="top-page">
