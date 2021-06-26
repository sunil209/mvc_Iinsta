<?php
/*
 * @example Basic example
 * Component::render('amp/segment');
 * @endexample
 */
 ?>

 <?php if ($analytics): ?>
  <amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-NBNSK7Z&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>
  <?php if (defined('INSTAPAGE_SEGMENT_KEY')): ?>
    <amp-analytics type="segment">
      <script type="application/json">
      {
        "vars": {
          "writeKey": "<?= INSTAPAGE_SEGMENT_KEY ?>",
          "name": "VIEW: <<?php wp_title('', true, 'right'); ?>>"
        },
        "extraUrlParams": {
          "properties.ampdocHost":            "AMPDOC_HOST",
          "properties.ampdocHostname":        "AMPDOC_HOSTNAME",
          "properties.ampdocUrl":             "AMPDOC_URL",
          "properties.canonicalHost":         "CANONICAL_HOST",
          "properties.canonicalHostname":     "CANONICAL_HOSTNAME",
          "properties.canonicalPath":         "CANONICAL_PATH",
          "properties.canonicalUrl":          "CANONICAL_URL",
          "properties.documentCharset":       "DOCUMENT_CHARSET",
          "properties.documentReferrer":      "DOCUMENT_REFERRER",
          "properties.externalReferrer":      "EXTERNAL_REFERRER",
          "properties.sourceUrl":             "SOURCE_URL",
          "properties.sourceHost":            "SOURCE_HOST",
          "properties.sourceHostname":        "SOURCE_HOSTNAME",
          "properties.viewer":                "VIEWER",
          "properties.contentLoadTime":       "CONTENT_LOAD_TIME",
          "properties.domainLookupTime":      "DOMAIN_LOOKUP_TIME",
          "properties.domInteractiveTime":    "DOM_INTERACTIVE_TIME",
          "properties.navRedirectCount":      "NAV_REDIRECT_COUNT",
          "properties.pageDownloadTime":      "PAGE_DOWNLOAD_TIME",
          "properties.pageLoadTime":          "PAGE_LOAD_TIME",
          "properties.redirectTime":          "REDIRECT_TIME",
          "properties.serverResponseTime":    "SERVER_RESPONSE_TIME",
          "properties.tcpConnectTime":        "TCP_CONNECT_TIME",
          "properties.timezone":              "TIMEZONE"
        },
        "triggers": {
          "clickCtaPostContent": {
            "on": "click",
            "selector": ".post-page .btn-cta",
            "request": "track",
            "vars": {
              "event": "CLICK: CTA in post content <TITLE>"
            },
            "extraUrlParams": {
              "properties.totalEngagedTime":  "TOTAL_ENGAGED_TIME"
            }
          },
          "clickCtaNavbar": {
            "on": "click",
            "selector": ".navbar-btn-singup",
            "request": "track",
            "vars": {
              "event": "CLICK: Navbar signup CTA"
            },
            "extraUrlParams": {
              "properties.totalEngagedTime":  "TOTAL_ENGAGED_TIME"
            }
          },
          "clickCtaBottomSection": {
            "on": "click",
            "selector": ".cta-section .btn-cta",
            "request": "track",
            "vars": {
              "event": "CLICK: CTA bottom section <TITLE>"
            },
            "extraUrlParams": {
              "properties.totalEngagedTime":  "TOTAL_ENGAGED_TIME"
            }
          },
          "clickFormSubmit": {
            "on": "click",
            "selector": "form input[type=\"submit\"]",
            "request": "track",
            "vars": {
              "event": "CLICK: Form submit button <TITLE>"
            },
            "extraUrlParams": {
              "properties.totalEngagedTime":  "TOTAL_ENGAGED_TIME"
            }
          }
        }
      }
      </script>
    </amp-analytics>
  <?php endif; ?>
<?php endif; ?>
