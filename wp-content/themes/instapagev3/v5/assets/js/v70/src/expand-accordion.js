var InstapageExpandAccordion = function(options) {
  this.defaults = {
    hiddenClass: 'v7-is-hidden',
    openClass: 'v7-accordion-open',
    selector: {
      wrapper: '.load-wrapper',
      expandHandle: '.js-expand-accordion',
      accordionBox: '.v7-accordion'
    }
  };
  Object.assign(this, _.extend(this.defaults, options || {}));
};

InstapageExpandAccordion.prototype.init = function () {
  jQuery(this.selector.expandHandle).on('click', (function (event) {
    var accordionHeader = event.target;
    var $accordionBox = jQuery(accordionHeader).closest(this.selector.accordionBox);

    this.toggleAccordion($accordionBox);
  }).bind(this));
};

InstapageExpandAccordion.prototype.toggleAccordion = function (accordion) {
  accordion.toggleClass(this.openClass);
  this.toggleIframe(accordion);
}

InstapageExpandAccordion.prototype.toggleIframe = function(accordion) {
  jQuery(accordion).find(this.selector.wrapper).toggleClass(this.hiddenClass);
  //Reload all iframes in the item on closing
  if (!jQuery(accordion).hasClass(this.openClass)) {
    this.reloadIframesInsideAccordions(accordion);
  }
}

InstapageExpandAccordion.prototype.reloadIframesInsideAccordions = function(accordion) {
  jQuery(accordion).find('iframe').each(function(index, iframeElement) {
    this.reloadIframe(iframeElement);
  }.bind(this));
}

InstapageExpandAccordion.prototype.reloadIframe = function(element) {
  var $iframe = jQuery(element);
  var iframeSrc = $iframe.attr('src') ? $iframe.attr('src') : ($iframe.attr('data-src') ? $iframe.attr('data-src') : '');

  if (!iframeSrc) {
    return;
  }

  $iframe.attr('src', iframeSrc);
}

InstapageExpandAccordion.prototype.expandAfterScroll = function(accordion) {
  var $accordionBox = jQuery(accordion);

  if (!$accordionBox.hasClass('v7-accordion')) {
    return;
  }

  $accordionBox.addClass(this.openClass);
  this.toggleIframe($accordionBox);
}
