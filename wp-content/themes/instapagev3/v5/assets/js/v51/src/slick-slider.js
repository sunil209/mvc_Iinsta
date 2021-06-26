var InstapageSlickSlider = function(options) {}

InstapageSlickSlider.prototype.init = function() {
  // NOTE: slick-slider presets
  var slickPresets = {
    'sliderTestimonial': {
      dots: true,
      slidesToShow: 3,
      slidesToScroll: 3,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 7000,
      responsive: [
      {
        breakpoint: 1170,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 749,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          prevArrow: '<div class="slick-prev"><i class="material-icons">keyboard_arrow_left</i></div>',
          nextArrow: '<div class="slick-next"><i class="material-icons">keyboard_arrow_right</i></div>',
          dots: false,
        }
      }
      ]
    },
    'sliderHeader': {
      arrows: false,
      dots: true,
      autoplay: true,
      autoplaySpeed: 4000,
      infinite: false
    },
    'sliderEmployee': {
      arrows: false,
      fade: true,
      swipe: false,
      slide: '.js-slick-slide',
      waitForAnimate: false
    },
    'featuredArticles': {
      dots: true,
      arrows: false,
      fade: true,
      autoplay: true,
      autoplaySpeed: 5000,
      adaptiveHeight: true
    }
};
  // NOTE: slick-slider init based on 'data-slick-preset'
  var preset = jQuery('.js-slick-container').data('slick-preset');
  if (typeof slickPresets[preset] !== 'undefined' && jQuery(slickPresets[preset]).length == 1) {
    jQuery('.js-slick-container').slick(slickPresets[preset]);
  }

  // NOTE: fix for slick initialization after unslick
  jQuery(window).resize(function() {
    if (jQuery(window).width() >= 749) {
      if (!jQuery('.js-slick-container').hasClass('slick-initialized')) {
        jQuery('.js-slick-container').slick(slickPresets[preset]);
      }
    }
  });

  this.appendAndActivateSliderNav();
}

// NOTE: Employee slider navigation functionality:
InstapageSlickSlider.prototype.appendAndActivateSliderNav = function() {
  var sliderEmployee = jQuery('.js-slider-employee');
  var firstSlide = jQuery('.carousel-content').first();
  var sliderNav = jQuery('.js-slick-navigation');
  var sliderNavItem = jQuery('.js-slick-navigation-item');

  var activateSliderNavigation = function activateSliderNav (element, e) {
    e.preventDefault();
    var goToSlide = jQuery(element).data('slide') - 1;

    sliderNavItem.removeClass('carousel-avatar-active');
    jQuery(element).addClass('carousel-avatar-active');
    sliderEmployee.slick('slickGoTo', goToSlide);
  }

  var activateAppendedSliderNavigation = function activateAppendedSliderNav (nextSlide) {
    var nextSlideNav = nextSlide + 1;
    var nextSlideNavItem = jQuery('.js-slick-slide[data-slick-index="' + nextSlide + '"] .js-slick-navigation-item[data-slide="' + nextSlideNav + '"]');

    nextSlideNavItem.addClass('carousel-avatar-active');
  }

  sliderNav.appendTo(firstSlide);
  sliderNavItem.first().addClass('carousel-avatar-active');

  sliderNavItem.click(function(e) {
    activateSliderNavigation(this, e);
  });

  sliderEmployee.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
    sliderNav.appendTo(jQuery('.js-slick-slide[data-slick-index="' + nextSlide + '"] .carousel-content'));
    sliderNavItem.removeClass('carousel-avatar-active');

    activateAppendedSliderNavigation(nextSlide);
  });
}
