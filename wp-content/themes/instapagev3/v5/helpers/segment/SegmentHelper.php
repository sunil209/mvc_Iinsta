<?php
namespace Instapage\Helpers\Segment;

class SegmentHelper
{
    /**
     * A Segment JS source ID.
     */
    const SEGMENT_ID = '8pIGE9UpYNvEaBNqs9dzmYCYDDVJ1r5z';

    /**
     * Returns script that has to be added to properly connect Segment and a JS source (like website).
     *
     * @return string JS snippet.
     */
    public static function getSegmentSnippet(): string
    {
        return self::getSegmentDestinationSelectorScript() . '
          <script>
            var loadSegment = function loadSegment(integrations) {
                !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t,e){var n=document.createElement("script");n.type="text/javascript";n.async=!0;n.src="https://cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(n,a);analytics._loadOptions=e};analytics.SNIPPET_VERSION="4.1.0";
                analytics.load("' . self::SEGMENT_ID . '", {
                  integrations: integrations
                });
                analytics.page();
              
                }}();
            }
          </script>';
    }

    private static function getSegmentDestinationSelectorScript(): string
    {
        ob_start();
        include __DIR__ . '/segmentDestinationsSelector.js';
        return '<script>' . ob_get_clean() . '</script>';
    }

    /**
     * Prints the result of getSegmentSnippet function. Should be used in HTML header, because it adds a JS Segment library and in an asynchronous way.
     *
     * @uses \Instapage\Helpers\SegmentHelper::getSegmentSnippet()
     */
    public static function renderSegmentSnippet()
    {
        echo self::getSegmentSnippet();
    }
}
