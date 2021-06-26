var InstapageExpandItem = function(options) {
  this.options = options;
  this.defaults = {
    wrapper: '.load-wrapper',
    hiddenClass: 'is-hidden',
    selector: '.js-expand-item',
    trigger: '.js-expand-trigger',
    stateOpen: 'open'
  };
  Object.assign(this, _.extend(this.defaults, this.options));
};

InstapageExpandItem.prototype.init = function() {
  if (!jQuery(this.trigger)[0]) {
    return false;
  }

  jQuery(this.selector).on('click', this.buttonCopyChange);
  var scope = this;

  jQuery(this.trigger).on('click', function(){
    var element = jQuery(this);
    var parent = element.closest(scope.selector);

    //Checking if parent or clicked element has <data-collapse="all">
    if (parent.data('collapse') === 'all' || element.data('collapse') === 'all') {
      var openedItems = parent.siblings('[data-state="' + scope.stateOpen+ '"]');
      openedItems.removeState(scope.stateOpen);
    }
    scope.toggle(this);
  });
};

InstapageExpandItem.prototype.toggle = function(element) {
  jQuery(element).find(this.wrapper).toggleClass(this.hiddenClass);
  jQuery(element).closest(this.selector).toggleState(this.stateOpen);
  //Reload all iframes in the item you just closed
  if (jQuery(element).attr('data-state') !== this.stateOpen) {
    this.reloadAllIframes(element);
  }
}

InstapageExpandItem.prototype.reloadAllIframes = function(item) {
  jQuery(item).find('iframe').each(function(index, iframeElement) {
    this.reloadIframe(iframeElement);
  }.bind(this));
}

InstapageExpandItem.prototype.reloadIframe = function(element) {
  var iframe = jQuery(element);
  var iframeSrc = iframe.attr('src') ? iframe.attr('src') : (iframe.attr('data-src') ? iframe.attr('data-src') : '');

  if (!iframeSrc) {
    return;
  }

  jQuery(element).attr('src', iframeSrc);
}

InstapageExpandItem.prototype.open = function(element) {
  jQuery(element).find(this.wrapper).removeClass(this.hiddenClass);
  jQuery(element).closest(this.selector).addState(this.stateOpen);
}

InstapageExpandItem.prototype.buttonCopyChange = function () {
  if (jQuery(this).attr('data-state') === 'open') {
    jQuery('.js-expand-link', this).text('less info')
  } else {
    jQuery('.js-expand-link', this).text('more info')
  }
}
