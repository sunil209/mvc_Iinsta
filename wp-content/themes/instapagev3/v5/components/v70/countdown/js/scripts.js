var InstapageCountdown = function(options) {
  this.options = options;
  this.defaults = {
    selector: '.js-countdown',
    selectorDateTime: '.js-countdown-date-time',
    containerDays: '.js-countdown-days',
    containerHours: '.js-countdown-hours',
    containerMinutes: '.js-countdown-minutes',
    containerSeconds: '.js-countdown-seconds'
  };
  Object.assign(this, _.extend(this.defaults, this.options));
};

InstapageCountdown.prototype.init = function() {
  if (!jQuery(this.selector)[0]) {
    return false;
  }

  var scope = this;

  setInterval(function() {
    scope.timeCounting();
    }, 1000);
};

InstapageCountdown.prototype.timeCounting = function() {
  var scope = this;

  var webinarDate = parseInt(jQuery(scope.selectorDateTime).attr('data-countdown'));
  var now = new Date();
  var nowDate = Math.round(now.getTime() / 1000);
  var intervalTime = webinarDate - nowDate;

  var daysDivider = 60 * 60 * 24;
  var hoursDivider = 60 * 60;
  var minutesDivider = 60;

  var numDays = Math.floor(intervalTime / daysDivider);
  var numHours = Math.floor((intervalTime / hoursDivider) - numDays * 24);
  var numMinutes = Math.floor((intervalTime / minutesDivider) - (numDays * 24 * 60) - (numHours * 60));
  var numSeconds = intervalTime - (numDays * 24 * 60 * 60) - (numHours * 60 * 60) - (numMinutes * 60);

  jQuery(scope.containerDays).text(scope.stringPad(numDays, 0));
  jQuery(scope.containerHours).text(scope.stringPad(numHours, 0));
  jQuery(scope.containerMinutes).text(scope.stringPad(numMinutes, 0));
  jQuery(scope.containerSeconds).text(scope.stringPad(numSeconds, 0));

};

InstapageCountdown.prototype.stringPad = function(object, pad) {
  if (object.toString().length === 1) {
    object = pad.toString() + object;
  }
  return object;
};
