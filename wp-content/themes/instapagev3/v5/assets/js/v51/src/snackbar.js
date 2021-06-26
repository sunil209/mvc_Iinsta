var InstapageSnackbar = function(options) {
  this.options = options;
  this.defaults = {
    selector: '.js-snackbar',
    selectorClose: '.js-snackbar-close',
    activeState: 'active',
    template: '<div class="snackbar [Selector]" data-state="[ActiveState]">\
                <span>[Message]</span>\
                <span class="snackbar-close material-icons [SelectorClose]" data-self="right center">close</span>\
              </div>'
  };
  Object.assign(this, _.extend(this.defaults, this.options));
};

InstapageSnackbar.prototype.init = function() {
  var scope = this;

  jQuery('body').on('click', scope.selectorClose, function () {
    jQuery(scope.selector).removeState(scope.activeState);
  });
};

InstapageSnackbar.prototype.create = function(message) {
  var scope = this;

  jQuery(scope.selector).remove();

  var html = scope.template
    .replace('[Selector]', scope.selector.substr(1))
    .replace('[ActiveState]', scope.activeState)
    .replace('[Message]', message)
    .replace('[SelectorClose]', scope.selectorClose.substr(1));

  jQuery('body').append(html);
}
