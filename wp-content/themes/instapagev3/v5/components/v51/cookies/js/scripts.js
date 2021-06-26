/* global instapage */

/**
 * Revealing module handling cookie consent.
 *
 * When user agree on cookie there is 'cookie_consent_user_agreed' event triggered.
 *
 */
var CookiesConsent = (function() {
  var $cookiesWrapper;
  var $agreeButton;
  var $disagreeButton;

  /**
   * State for showing cookies wrapper with cookie consent, this need to be add or removed.
   *
   * @type {String}
   */
  var shownState = 'shown';
  /**
   * Name of cookie holding user decision.
   *
   * @type {String}
   */
  var cookieName = 'i_uc';
  var cookieNameSoft = 'i_ucs';
  var cookieAgreeValue = 1;
  var cookieDisagreeValue = 0;
  var cookieExpireInDays = 360;

  /**
   * Get jQuery objects of all needed elements, and store them for later reference.
   *
   * @returns {void}
   */
  var hookElements = function hookElements() {
    $cookiesWrapper = jQuery('.js-cookies-wrapper');
    $agreeButton = $cookiesWrapper.find('.js-cookies-agree');
    $disagreeButton = $cookiesWrapper.find('.js-cookies-disagree');
  };

  /**
   * Starts up all needed elements.
   *
   * @returns {void}
   */
  var init = function init() {
    hookElements();
    setVisibility();
    bindEventListeners();

    // cookies consent script was loaded so it can be used by other scripts
    jQuery(document).trigger('cookies_consent_loaded');
  };

  /**
   * Hook events listeners, it is event based module.
   *
   * @returns {void}
   */
  var bindEventListeners = function bindEventListeners() {
    $agreeButton.click(function () {
      userAgree();
    });
    $disagreeButton.click(function (e) {
      e.preventDefault();
      userDisagree();
      window.location = jQuery(this).attr('href');
    });

    /**
     * We need to be 100% sure that at first visit we do not load scripts for visitor,
     * so we wait for segment loader done checking if load segment and then we create soft consent
     */
    jQuery(document).on('segment_loader_done_checking', (function (event) {
      userSoftConsent();
    }));
  };

  /**
   * Method intend to be called when user click agree button.
   *
   * @returns {void}
   */
  var userAgree = function userAgree() {
    instapage.cookie.setCookie(cookieName, cookieAgreeValue, cookieExpireInDays);
    setVisibility();
    // user agreed to cookie consent, trigger event on document to let know other scripts
    jQuery(document).trigger('cookie_consent_user_agreed');
  };

  /**
   * Method intend to be called when user click disagree button.
   *
   * @returns {void}
   */
  var userDisagree = function userDisagree() {
    instapage.cookie.setCookie(cookieName, cookieDisagreeValue, cookieExpireInDays);
    setVisibility();
  };

  /**
   * Method intend to be called when user gets soft consent.
   *
   * @returns {void}
   */
  var userSoftConsent = function userSoftConsent() {
    instapage.cookie.setCookie(cookieNameSoft, cookieAgreeValue, cookieExpireInDays);
  };

  /**
   * Does user agreed or have seen on our cookies policy? Return true if yes, otherwise false.
   *
   * @returns {Boolean}
   */
  var doesUserAgreed = function doesUserAgreed() {
    var consent = parseInt(instapage.cookie.getCookie(cookieName));
    var consentSoft = parseInt(instapage.cookie.getCookie(cookieNameSoft));
    return consent === 1 || consentSoft === 1;
  };

  /**
   * Set visibility of cookie consent message based on cookie value.
   *
   * Cookie has decision made by user.
   *
   * @returns {void}
   */
  var setVisibility = function setVisibility() {
    var consent = parseInt(instapage.cookie.getCookie(cookieName));
    // has user decided? If yes hide cookie message
    if (consent === 1 || consent === 0) {
      $cookiesWrapper.removeState(shownState);
    // or let him decide
    } else {
      $cookiesWrapper.addState(shownState);
    }
  };

 // reveal neccessary methods, othere are private - encapsulation
  return {
    init: init,
    doesUserAgreed: doesUserAgreed
  };
})();

jQuery(document).on('instapage_loaded', function() {
  // initialize cookie consent mechanism only for people from Europe Union
  if (checkInEU()) {
   CookiesConsent.init();
  }
});
