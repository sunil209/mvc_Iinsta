// Initializing animation when image repeater is visible
jQuery(document).ready(function() {
  var animationContainer = jQuery('.js-v7-group-animation-container');
  if (animationContainer.length) {
    jQuery(window).on('scroll', function() {
      if (animationContainer.visible(true)) {
        animationContainer.addClass('v7-group-animation-active');
      }
    });
  }
});
