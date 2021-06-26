(function () {
  'use_strict';

  /**
   * Initialize whole Google Analytics Discovery
   *
   * @returns {void}
   */
  var init = function init() {
    discoverGoogleAnalytics();
  };

  /**
   * Start method for google analytics discover, when it only finds Google Analytics
   * it will emit `discovery:google-analytics` event on document element
   *
   * @returns {void}
   */
  var discoverGoogleAnalytics = function discoverGoogleAnalytics() {
    if (window.ga) {
      emitGoogleAnalyticsDiscovery();
    } else {
      setTimeout(discoverGoogleAnalytics, 500);
    }
  };

  /**
   * Emit event on document about google analytics service discovery
   *
   * @returns {void}
   */
  var emitGoogleAnalyticsDiscovery = function emitGoogleAnalyticsDiscovery() {
    var event = document.createEvent('Event');
    event.initEvent('discovery:google-analytics', true, true);
    document.dispatchEvent(event);
  };

  // Fire all discovery logic
  init();
})();
