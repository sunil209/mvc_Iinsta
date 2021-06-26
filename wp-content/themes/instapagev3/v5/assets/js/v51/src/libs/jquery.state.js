(function($) {
  var stateAttribute = 'data-state',
      stateSeparator = ' ',
      uniqueFilter = function(value, index, self) {
        return self.indexOf(value) === index;
      },
      getStates = function(element) {
        var stateAttributeValue = element.attr(stateAttribute),
            states = [];
        if (typeof stateAttributeValue !== 'undefined') {
          states = stateAttributeValue.split(stateSeparator);
        }
        return states;
      };

  $.fn.hasState = function(stateToCheck) {
    var flag = false;

    this.each(function() {
      var element = $(this),
          states = getStates(element);

      if (states.indexOf(stateToCheck) !== -1) {
        flag = true
      }

    });
    return flag;
  };

  $.fn.addState = function(stateToAdd) {
    this.each(function() {
      var element = $(this),
          states = getStates(element);

      states.push(stateToAdd);
      states = states.filter(uniqueFilter)

      element.attr(stateAttribute, states.join(stateSeparator).trim());
    });
    return this;
  };

  $.fn.removeState = function(stateToRemove) {
    this.each(function() {
      var element = $(this),
          states = getStates(element);

      var stateToRemoveIndex = states.indexOf(stateToRemove);
      if (stateToRemoveIndex !== -1) {
        states.splice(stateToRemoveIndex, 1);
      }

      element.attr(stateAttribute, states.join(stateSeparator).trim());
    });
    return this;
  };

  $.fn.toggleState = function(stateToToggle) {
    this.each(function() {
      var element = $(this);

      if (element.hasState(stateToToggle)) {
        element.removeState(stateToToggle);
      }
      else {
        element.addState(stateToToggle);
      }
    });
    return this;
  };
}(jQuery));
