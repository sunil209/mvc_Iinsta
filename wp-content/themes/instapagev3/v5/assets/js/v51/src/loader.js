
;(function () {
    'use_strict';
  
    var loadContentLoader = function loadContentLoader(){
        var $getInstaLoader = jQuery('.v7-insta-loader');
        var $getInstaLoaderContent = jQuery('.v7-insta-loader .v7-loader-content');
        if($getInstaLoader && $getInstaLoaderContent){
            setTimeout(function () {
                $getInstaLoader.addClass('loaded-content');
                $getInstaLoaderContent.removeClass("v7-invisible-content");
            }, 400);
        }
    }

    jQuery(document).ready(function() {
      loadContentLoader();
    });

}());
  