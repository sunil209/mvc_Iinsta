!(function(jQuery) {
  jQuery.fn.ipRipple = function() {
    if (!this.length) {
      return false;
    }

    var selectorNames = {
      fxInk: '.fx-ink'
    };
    var classNames = {
      fxInk: 'fx-ink',
      fxAnimate: 'fx-animate'
    };
    var ripplerTime = 400;

    this.each(function () {
      initRipple.call(this, selectorNames, classNames, ripplerTime);
    });
  };

  function initRipple(selectorNamesSpace, classNamesSpace, timeToOff) {
    var $trigger = jQuery(this);

    $trigger.on('mousedown', function (e) {
      var rippler = jQuery(this);
      var ink = jQuery('<span class=' + classNamesSpace.fxInk +'></span>');

      makeInkElement(rippler, ink, selectorNamesSpace, classNamesSpace);
      setDiameterInkElement(rippler, ink);
      setPinPointInkElement(e, rippler, ink, classNamesSpace);
      offInkElement(ink, timeToOff);
    });
  }

  function makeInkElement(ripplerElement, inkElement, selectorNamesSpace, classNamesSpace) {
    jQuery(selectorNamesSpace.fxInk).remove();
    if (ripplerElement.find(selectorNamesSpace.fxInk).length === 0) {
      ripplerElement.append(inkElement);
    }
    inkElement.removeClass(classNamesSpace.fxAnimate);
  }

  function setDiameterInkElement(ripplerElement, inkElement) {
    var inkElementHeight = inkElement.height();
    var inkElementWidth = inkElement.width();

    if (!inkElementHeight && !inkElementWidth) {
      var diameter = Math.max(ripplerElement.outerWidth(), ripplerElement.outerHeight());
      inkElement.css({
        height: diameter,
        width: diameter
      });
    }
  }

  function setPinPointInkElement(e, ripplerElement, inkElement, classNamesSpace) {
    var x = e.pageX - ripplerElement.offset().left - inkElement.width() / 2;
    var y = e.pageY - ripplerElement.offset().top - inkElement.height() / 2;

    inkElement.css({
      top: y + 'px',
      left: x + 'px'
    }).addClass(classNamesSpace.fxAnimate);
  }

  function offInkElement(inkElement, timeToOff) {
    setTimeout(function() {
      inkElement.remove();
    }, timeToOff);
  }
})(jQuery);
