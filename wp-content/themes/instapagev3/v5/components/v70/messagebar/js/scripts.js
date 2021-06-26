/* global instapage */

/**
 * Revealing module handling message bar.
 *
 */
var MessageBar = (function() {
  var $messageBarWrapper;
  var $messageBarButton;

  /**
   * State for showing messagebar wrapper.
   *
   * @type {String}
   */
  var shownState = 'shown';
  /**
   * Name of cookie holding user decision.
   *
   * @type {String}
   */
  var cookieName = 'i_msgbar_';
  var cookieAgreeValue = 1;
  var cookieDisagreeValue = 0;
  var cookieExpireInDays = 360;

  /**
   * Method intend to be called when user clicks 'click here' button.
   *
   * @returns {void}
   */
  var userAgree = function userAgree() {
    instapage.cookie.setCookie(cookieName, cookieAgreeValue, cookieExpireInDays);
    setVisibility();
  };

  /**
   * Get jQuery objects of all needed elements, and store them for later reference.
   *
   * @returns {void}
   */
  var hookElements = function hookElements() {
    $messageBarWrapper = jQuery('.js-message-bar-wrapper');
    $messageBarButton = $messageBarWrapper.find('.js-btn-message-bar');
  };

  /**
   * Starts up all needed elements.
   *
   * @returns {void}
   */
  var init = function init() {
    cookieName += jQuery('input[name="messagebar-hash"]').val();
    hookElements();
    setVisibility();
    bindEventListeners();
  };

  /**
   * Hook events listeners, it is event based module.
   *
   * @returns {void}
   */
  var bindEventListeners = function bindEventListeners() {
    $messageBarButton.click(function () {
      userAgree();
    });
  };

  /**
   * Method intend to be called when user click 'click here' button.
   *
   * @returns {void}
   */
  var userAgree = function userAgree() {
    instapage.cookie.setCookie(cookieName, cookieAgreeValue, cookieExpireInDays);
    setVisibility();
  };

  /**
   * Does user followed the link to 3rd party page? Return true if yes.
   *
   * @returns {Boolean}
   */
  var doesUserAgreed = function doesUserAgreed() {
    var consent = parseInt(instapage.cookie.getCookie(cookieName));
    return consent === 1;
  };

  /**
   * Set visibility of messagebar based on cookie value.
   *
   * Cookie has decision made by user.
   *
   * @returns {void}
   */
  var setVisibility = function setVisibility() {
    // has user decided? If yes hide messagebar
    if (doesUserAgreed()) {
      $messageBarWrapper.removeState(shownState);
    // or let him decide
    } else {
      $messageBarWrapper.addState(shownState);
      $messageBarWrapper.removeAttr("style");
    }
  };

  // reveal neccessary methods, others are private - encapsulation
  return {
    init: init,
    doesUserAgreed: doesUserAgreed
  };
})();

jQuery(document).on('instapage_loaded', function() {
  MessageBar.init();
});
