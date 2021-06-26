// Responsive lazy loading
window.lazySizesConfig = window.lazySizesConfig || {};
lazySizesConfig.expand = 750;

if (jQuery('.page-template-templates').length) {
  lazySizesConfig.expand = 250;
}

// Initializing gallery
jQuery(document).ready(function () {
  var $galleryWrapper = jQuery('.js-gallery-wrapper');
  if ($galleryWrapper.length) {
    $galleryWrapper.each(function () {
      jQuery(this).children('.js-gallery').featherlightGallery();
    });
  }
});
