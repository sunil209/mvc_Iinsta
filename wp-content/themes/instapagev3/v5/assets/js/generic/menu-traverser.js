/**
 * Revealing module for menuTraverser
 */

var menuTraverser = (function() {
  'use_strict';

  /**
   * Object containing config for menuTraverser
   *
   * @type object
   */
  var config = {
    mainMenuTopLevelSelector: '.js-navbar-menu-top-level',
    mainMenuTopLevelSelectorMobile: '.js-navbar-menu-top-level-mobile',
    activeClass: 'current-menu-parent'
  };

  /**
   * Starts up all needed elements.
   *
   * @returns {void}
   */
  var init = function init() {
    highlighActive();
  };

  /**
   * Run function for highlighting for each nav elements based on given selector
   *
   * @returns {void}
   */
  var highlighActive = function highlighActive() {
    jQuery(config.mainMenuTopLevelSelector).each(findAndActivateMenuCategory);
    jQuery(config.mainMenuTopLevelSelectorMobile).each(findAndActivateMenuCategory);
  }

  /**
   * Highlight active top level element based on current page that user is viewing
   *
   * @returns {boolean}
   */
  function findAndActivateMenuCategory() {
    var breakout;
    var $currentTopLevel = jQuery(this);
    var $anchors = $currentTopLevel.find('a');

    // iterate trough $anchors inside $currentTopLevel menu position
    $anchors.each(function () {
      var anchorUrl = this.href;
      if (anchorUrl.endsWith(window.location.pathname) && anchorUrl.includes(window.location.hostname)) {
        $currentTopLevel.addClass(config.activeClass);
        return breakout = false;
      }
    });

    return breakout;
  };

  // reveal only neccessary method, others are private
  return {
    init: init
  };
})();

jQuery(document).ready(function() {
  menuTraverser.init();
});
