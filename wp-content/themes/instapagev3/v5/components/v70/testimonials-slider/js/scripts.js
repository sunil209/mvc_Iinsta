;(function () {
  'use_strict';

  var mediaQuery = window.matchMedia('(min-width: 970px)');
  var isSliderInitilized = false;
  var testimonialSliderSelector = '.js-v7-testimonials-slider';

  var init = function init() {
    checkIfSliderShouldBeInitilized(mediaQuery);
    mediaQuery.addListener(checkIfSliderShouldBeInitilized);
  }

  var checkIfSliderShouldBeInitilized = function checkIfSliderShouldBeInitilized(mediaQuery) {
    if (mediaQuery.matches) {
      initilizeTestimonialsSlider();
    }
  }

  var initilizeTestimonialsSlider = function initilizeTestimonialsSlider() {
    if (!isSliderInitilized) {
      isSliderInitilized = true;

      jQuery(testimonialSliderSelector).slick({
        'prevArrow': '<span class="v7-previous-slide-round fx-ripple-effect">' +
          '<i class="material-icons">keyboard_arrow_left</i>' +
          '</span>',
        'nextArrow': '<span class="v7-next-slide-round fx-ripple-effect">' +
          '<i class="material-icons">keyboard_arrow_right</i>' +
          '</span>'
      })
    }
  }

  jQuery(document).ready(function() {
    init();
  });
})();

