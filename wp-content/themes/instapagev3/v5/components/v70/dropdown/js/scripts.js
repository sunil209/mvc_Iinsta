;(function () {
  'use_strict';
  var thumbnailsDropdownSelector = '.v7-dropdown-trigger-content';
  var navigationItemSelector = '.js-filter-single';
  var $navigationItems = jQuery(navigationItemSelector);
  var $thumbnailsDropdown = jQuery(thumbnailsDropdownSelector);

  /**
   * Synchronize dropdown trigger with current dropdown option.
   *
   * @returns {void}
   */
  var changeContent = function changeContent(event) {
    var newText = jQuery(event.target).text();
    $thumbnailsDropdown.text(newText);
  };

  /**
   * Define all events happening.
   *
   * @returns {void}
   */
  var hookEvents = function hookEvents() {
    $navigationItems.on('click', changeContent);
  }

  /**
   * Starts up all needed elements.
   *
   * @returns {void}
   */
  var init = function init() {
    hookEvents();
  };

  jQuery(document).ready(function() {
    init();
  });
}());
