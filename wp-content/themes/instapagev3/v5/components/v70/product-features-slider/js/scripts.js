;(function () {
  'use_strict';

  var mediaQuery = window.matchMedia('(min-width: 1170px)');
  var isSliderInitilized = false;
  var sliderSelector = '.js-v7-product-features-slider';
  var navigationItemSelector = '.js-v7-product-features-navigation li';

  var $navigationItems = null;
  var $sliderInstance = null;

  var init = function init() {
    $navigationItems = jQuery(navigationItemSelector);
    checkIfSliderShouldBeInitilized(mediaQuery);
    mediaQuery.addListener(checkIfSliderShouldBeInitilized);
  }

  var hookEvents = function hookEvents() {
    $sliderInstance.on('beforeChange', function (event, slickInstance, currentSlide, nextSlide) {
      highlightNavigationItem(nextSlide);
    });
  }

  var highlightNavigationItem = function highlightNavigationItem(itemIndex) {
    $navigationItems.removeState('active');
    jQuery(navigationItemSelector + '[data-product-feature="' + itemIndex + '"]').addState('active');
  }

  var initializeSliderNavigation = function initializeSliderNavigation() {
    $navigationItems.click(function () {
      $navigationItem = jQuery(this);
      switchSliderTo = parseInt($navigationItem.data('product-feature'), 10);

      $navigationItems.removeState('active');
      $navigationItem.addState('active');
      $sliderInstance.slick('slickGoTo', switchSliderTo);
    })
  }

  var checkIfSliderShouldBeInitilized = function checkIfSliderShouldBeInitilized(mediaQuery) {
    if (mediaQuery.matches) {
      initilizeProductFeaturesSlider();
    }
  }

  var initilizeProductFeaturesSlider = function initilizeProductFeaturesSlider() {
    if (!isSliderInitilized) {
      isSliderInitilized = true;

      $sliderInstance = jQuery(sliderSelector).slick({
        'prevArrow': '<span class="v7-previous-slide-round fx-ripple-effect">' +
          '<i class="material-icons">keyboard_arrow_left</i>' +
          '</span>',
        'nextArrow': '<span class="v7-next-slide-round fx-ripple-effect">' +
          '<i class="material-icons">keyboard_arrow_right</i>' +
          '</span>',
      });

      initializeSliderNavigation();
      hookEvents();
    }
  }

  jQuery(document).ready(function() {
    init();
  });
})();

