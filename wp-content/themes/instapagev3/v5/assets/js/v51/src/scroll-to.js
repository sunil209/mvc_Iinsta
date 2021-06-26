var InstapageScrollToElement = function(options) {
  this.options = options;
  this.defaults = {
    accordionClass: 'js-expand-accordion',
    menuItems: '.js-sidebar a',
    scrollOffset: 150,
    animationDuration: 500,
    scrollDelay: 200
  };
  Object.assign(this, _.extend(this.defaults, this.options));
};

InstapageScrollToElement.prototype.init = function() {
  var scope = this;

  /**
   * Prevent function from runnign when sidebar is a filter.
  */
  if (jQuery(scope.menuItems).hasClass('js-filter-single')) {
    return;
  }

  jQuery(document).on('click', 'a[href^=\\#]', function(e) {
    e.preventDefault();
    scope.scroll(jQuery(this));
  });

  if (jQuery('.js-sidebar').length > 0) {
    jQuery(window).on('scroll', function() {
      setTimeout(
        function() {
          var scrollPos = jQuery(document).scrollTop() + scope.scrollOffset;
          scope.toggleActiveOnScroll(scope, scrollPos);
        },
        scope.scrollDelay
      );
    });
  }

  jQuery(document).ready(function() {
    scope.scroll(jQuery('a[href="' + location.hash + '"]'));
  })
};

InstapageScrollToElement.prototype.toggleActiveOnScroll = function(scope, scrollPosition) {
  jQuery(scope.menuItems).each(function () {
    var currentLink = jQuery(this);
    var refElement = jQuery(currentLink.attr('href'));
    var positionElement = refElement.position();
    if (
        positionElement !== undefined
        && positionElement.top <= scrollPosition
        && positionElement.top + refElement.height() > scrollPosition
      ) {
      jQuery(scope.menuItems).removeState('active');
      currentLink.addState('active');
    } else {
      currentLink.removeState('active');
    }
  });
}

InstapageScrollToElement.prototype.scroll = function(element) {
  var scope = this;
  var target = element.attr('href');
  var dataScrollOffset = element.attr('data-scroll');

  if (dataScrollOffset !== undefined && jQuery.isNumeric(dataScrollOffset) == true) {
    scope.scrollOffset = dataScrollOffset;
  }

  if ((target !== '#') && (jQuery(target).length)) {
    jQuery('html, body').animate(
      {
        scrollTop: jQuery(target).offset().top - scope.scrollOffset
      },
      scope.animationDuration,
      function() {
        setTimeout(
          function() {
            scope.callbackAfterScroll(target, scope.accordionClass);
          },
          scope.scrollDelay
        );
      }
    );
  }
};

InstapageScrollToElement.prototype.callbackAfterScroll = function(target, elementClass) {
  if (jQuery(target).find(elementClass)) {
    instapage.expandAccordion.expandAfterScroll(target);
  }
};
