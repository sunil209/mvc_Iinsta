var InstapageVideo = function(options) {
  this.options = options;
  this.defaults = {
    trigger: '.js-video-trigger',
    closeButton: '.js-video-close'
  };
  Object.assign(this, _.extend(this.defaults, this.options));
};
  
InstapageVideo.prototype.init = function() {
  var scope = this;
  var checkActiveElement = '';
  var activeVideo = '';

  // NOTE: Open the video.
  jQuery(scope.trigger).on('click', function(e){
    e.preventDefault();

    activeVideo = jQuery('.' + jQuery(this).data('video-id'));
    activeVideo.attr('src', activeVideo.data('src')).parent().addState('active');

    // NOTE: This is how we can still use 'ESC' button to leave the video modal.
    checkActiveElement = setInterval(function(){
      var element = document.activeElement;
      if(element && element.tagName == 'IFRAME'){
        // TODO: This solution doesn't work in FF.
        jQuery(window).focus();
      }
    }, 500);

    jQuery('body').addState('blocked');
  });

  // NOTE: Close the video.
  jQuery(document).keyup(function(e) {
    var escButton = 27;
    if ((e.keyCode == escButton) && activeVideo.length) {
      scope.close(activeVideo, checkActiveElement);
    }
  });

  // NOTE: Close the video.
  jQuery(scope.closeButton).on('click', function(){
    scope.close(activeVideo, checkActiveElement);
  });
};

InstapageVideo.prototype.close = function(videoToClose, functionToEnd) {
  videoToClose.attr('src', '').parent().removeState('active');
  clearInterval(functionToEnd);
  jQuery('body').removeState('blocked');
}



