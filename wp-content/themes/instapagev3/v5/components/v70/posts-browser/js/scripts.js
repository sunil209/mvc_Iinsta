;(function () {
  'use_strict';

  var isSliderInitilized = false;
  var sliderSelector = '.js-v7-posts-browser-slider';
  var navigationItemSelector = '.js-v7-posts-browser-navigation-item';
  var sliderHeaderSelector = '.js-v7-posts-browser-header h2';
  var sliderDropdownPlaceholder = '.v7-dropdown-trigger-content';

  var $navigationItems = null;
  var $sliderInstance = null;

  /**
   * Synchronize navigation with the slider.
   *
   * @returns {void}
   */
  var highlightNavigationItem = function highlightNavigationItem(itemIndex) {
    $navigationItems.removeState('active');
    jQuery(navigationItemSelector + '[data-posts-browser="' + itemIndex + '"]').addState('active');
  };

  /**
   * Synchronize component header content with navigation.
   *
   * @returns {void}
   */
  var changeHeaderContent = function changeHeaderContent(itemIndex) {
    var $sliderDropdownPlaceholder = jQuery(sliderDropdownPlaceholder);
    var newText = jQuery(navigationItemSelector + '[data-posts-browser="' + itemIndex + '"]').first().text();
    $sliderHeader.text(newText);
    $sliderDropdownPlaceholder.text(newText);
  };

  /**
   * Get jQuery objects of all needed elements, and store them for later reference.
   *
   * @returns {void}
   */
  var hookElements = function hookElements() {
    $sliderHeader = jQuery(sliderHeaderSelector);
    $navigationItems = jQuery(navigationItemSelector);
  }

  /**
   * Define all events happening after initialization.
   *
   * @returns {void}
   */
  var hookEvents = function hookEvents() {
    $sliderInstance.on('afterChange', function (event, slickInstance, currentSlide, nextSlide) {
      changeHeaderContent(currentSlide);
      highlightNavigationItem(currentSlide);
    });

    $navigationItems.click(function () {
      var $navigationItem = jQuery(this);
      var switchSliderTo = parseInt($navigationItem.data('posts-browser'), 10);

      $navigationItems.removeState('active');
      $navigationItem.addState('active');
      $sliderInstance.slick('slickGoTo', switchSliderTo);
    });
  };

  /**
   * Initialize the slider.
   *
   * @returns {void}
   */
  var initilizePostsBrowserSlider = function initilizePostsBrowserSlider() {
    if (!isSliderInitilized) {
      isSliderInitilized = true;

      $sliderInstance = jQuery(sliderSelector).slick({
        fade: true,
        adaptiveHeight: true,
        arrows: false
      });
      hookEvents();
    }
  };

  /**
   * Starts up all needed elements.
   *
   * @returns {void}
   */
  var init = function init() {
    hookElements();
    initilizePostsBrowserSlider();
  };

  jQuery(document).ready(function() {
    init();
  });
}());
