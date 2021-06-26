/* global CookiesConsent, loadSegment */

/**
 * Object for handling dynamic injection of segment when user agrees on cookie consent.
 * Whole logic is fired only for people from UE, for others segment is immediatelly loaded
 *
 * Note:  Segment is loaded in people from UE only when they agree for tracking (cookie consent)
 *        BUT not immedietally when they clicked
 *
 * @returns {SegmentLoader}
 */
var SegmentLoader = function() {

  /**
   * Load Segment only once, this flags guarantees this.
   *
   * @type {boolean}
   */
  this.isLoaded = false;
};

/**
 * Init segment loader, for non EU load imediatelly segment
 *
 * @returns {void}
 */
SegmentLoader.prototype.init = function init() {
  // for EU do all stuff for checking consent etc
  if (checkInEU()) {
    this.addListeners();
  // for rest of the world just load Segment
  } else {
    this.load(segmentDestinationsSelector.getListOfIntegrationToLoadOnCurrentPage());
  }
};

/**
 * Hook events listeners, it is event based module.
 * We are listening for events emitted from cookie consent module
 *
 * @returns {void}
 */
SegmentLoader.prototype.addListeners = function addListeners() {
  jQuery(document).on('cookies_consent_loaded', (function () {
    this.loadIfUserAgreed();
  }).bind(this));
};

/**
 * Load only if user gave consent
 *
 * @returns {void}
 */
SegmentLoader.prototype.loadIfUserAgreed = function loadIfUserAgreed() {
  if (CookiesConsent.doesUserAgreed()) {
    this.load(segmentDestinationsSelector.getListOfIntegrationToLoadOnCurrentPage());
  } else {
    // if user just enter on page load only anonymized Google Analytics
    this.load({
      'All': false,
      'Google Analytics': true
    });
  }

  // segment done checking if he should load segment snippet in the page
  jQuery(document).trigger('segment_loader_done_checking');
}

/**
 * Load segment, but only once
 *
 * @param {object} integrations  Object containing configuration which integration to load,
 *                              according to: https://segment.com/docs/sources/website/analytics.js/#selecting-destinations
 *
 * @returns {void}
 */
SegmentLoader.prototype.load = function load(integrations) {
  if (this.isLoaded === false) {
    loadSegment(integrations);
    this.isLoaded = true;
  }
}
