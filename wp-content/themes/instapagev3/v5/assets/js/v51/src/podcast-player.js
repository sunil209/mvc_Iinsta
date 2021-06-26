/* globals jQuery */
var InstapagePlayer = function InstapagePlayer() {
  this.selectorPlayerTrigger = '.js-player-trigger';
  this.selectorModalClose = '.js-player-close';
  this.selectorPlayerIframe = '.js-player-wrapper';
  this.selectorDriftWidgetContainer = '#drift-widget-container';
  this.shownState = 'shown';
  this.hiddenState = 'hidden';
  this.pauseButton = '.playButton';
  this.podcastItem = '.js-podcast-item';

  var scope = this;
  var widget = null;

  if (jQuery('body').hasClass('post-type-archive-podcast')) {

    jQuery('body').on('click', scope.selectorPlayerTrigger, function playerTriggerClick(e) {
      e.preventDefault();
      var widgetIframe = jQuery(this).closest('.v7-box').find('iframe')[0];

      if (widgetIframe !== undefined) {
        widget = SC.Widget(widgetIframe);

        jQuery(scope.selectorDriftWidgetContainer).addState(scope.hiddenState);
        jQuery(scope.selectorPlayerIframe).removeState(scope.shownState);
        jQuery(this).closest('.v7-box').find(scope.selectorPlayerIframe).addState(scope.shownState);
        widget.play();

        return false;
      }
    });

    jQuery('body').on('click', selectorModalClose, function soundcloudModalCloseClicked(e) {
      e.preventDefault();

      jQuery(scope.selectorDriftWidgetContainer).removeState(scope.hiddenState);
      jQuery(this).closest('.v7-box').find(scope.selectorPlayerIframe).removeState(scope.shownState);

      if (widget !== null) {
        widget.pause();
      }
    });
  }
}
