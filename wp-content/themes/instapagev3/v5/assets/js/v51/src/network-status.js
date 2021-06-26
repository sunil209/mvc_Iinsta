var InstapageNetworkStatus = function() { };

InstapageNetworkStatus.prototype.init = function() {
  var scope = this;

  jQuery(window).on('online', scope.online);
  jQuery(window).on('offline', scope.offline);
};

InstapageNetworkStatus.prototype.online = function(e) {
  instapage.snackbar.create('You are now online');
};

InstapageNetworkStatus.prototype.offline = function(e) {
  instapage.snackbar.create('Your computer is offline');
};
