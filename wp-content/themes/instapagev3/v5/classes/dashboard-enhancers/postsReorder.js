/**
 * Revealing module handling post menu order parameters refreshing on drag
 *
 */
var postReorderEnhancer = (function () {
  /**
   * jQuery object for all posts list with sorting option
   *
   * @type jQuery
   */
  var $postList = null;

  /**
   * jQuery object for input with current page
   *
   * @type jQuery
   */
  var $currentPageInput = null;

  /**
   * jQuery object for input with items per page number to know how many posts we're showing at page
   *
   * @type {jQuery}
   */
  var $itemsPerPageInput = null;
  var itemsPerPage = null;
  var currentPage = null;
  var offset = 1;

  /**
   * Init refcalculating menu order parameter for post on drag.
   *
   * @returns {void}
   */
  var init = function init() {
    hookElements();
    getOrderOffset();
    bindEventListeners();
  };

  /**
   * Hook all needed elements
   *
   * @returns {void}
   */
  var hookElements = function hookElements() {
    $postList = jQuery('table.posts #the-list, table.pages #the-list');
    $currentPageInput = jQuery('#current-page-selector');
    $itemsPerPageInput = jQuery('#edit_post_per_page');
  };

  /**
   * Bind listeners to respond to user actions
   *
   * @returns {void}
   */
  var bindEventListeners = function bindEventListeners() {
    $postList.on('sortupdate', function (event) {
      refreshMenuNumbers(event.currentTarget);
    });
  };

  /**
   * Calculate offset for menu order renumbering.
   * For example on 2 page offset is 21, on 3 41 etc.
   *
   * @returns {Number}
   */
  var getOrderOffset = function getOrderOffset() {
    currentPage = parseInt($currentPageInput.val());
    itemsPerPage = parseInt($itemsPerPageInput.val());

    if (isNaN(currentPage) || isNaN(itemsPerPage)) {
      return offset;
    }

    offset = (currentPage - 1) * itemsPerPage + 1;
  };

  /**
   * Recalculate menu order parameters for post on drag
   *
   * @param {string|jQuery} table
   * @returns {void}
   */
  var refreshMenuNumbers = function refreshMenuNumbers(table) {
    jQuery(table).find('tr:visible').each(function (index) {
      jQuery('td.menu-order', jQuery(this)).html(index + offset);
    });
  };

  return {
    init: init
  };
})();


jQuery('document').ready(function () {
  postReorderEnhancer.init();
});

