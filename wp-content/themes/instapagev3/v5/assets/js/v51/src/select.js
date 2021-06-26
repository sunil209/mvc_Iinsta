var InstapageSelect = function (options) {
  this.options = options;
  this.defaults = {
    selectorMain: '.js-select',
    selectionClass: 'is-selected',
  };
  Object.assign(this, _.extend(this.defaults, this.options));
};

InstapageSelect.prototype.init = function () {
  if (!jQuery(this.selectorMain)[0]) {
    return false;
  }

  var scope = this;

  jQuery(scope.selectorMain).select2({
    minimumResultsForSearch: -1
  })
    .on('select2:select', scope.onSelect.bind(this))
    .on('select2:open', scope.onOpen)
    .on('select2:close', scope.onClose);
};

InstapageSelect.prototype.onSelect = function (e) {
  var container = jQuery(e.target).parent();
  var elementWithFillState = jQuery(container).children().first();
  var chosenPosition = jQuery(container).find('.select2-selection__rendered');
  var chosenPositionVal = jQuery(chosenPosition).text();

  jQuery(e.target).addClass(this.selectionClass);
  if (chosenPositionVal) {
    jQuery(elementWithFillState).addState(window.instapage.select.filledState);
  } else {
    jQuery(elementWithFillState).removeState(window.instapage.select.filledState);
  }
};

InstapageSelect.prototype.onOpen = function () {
  var select2dropdown = jQuery('.select2-dropdown');
  var noEventsClass = 'select2-dropdown--noevents';

  select2dropdown.removeState('open');
  select2dropdown.addClass(noEventsClass);
  setTimeout(function () {
    select2dropdown.removeClass(noEventsClass);
    select2dropdown.addState('open');
    }, 200 );
};
