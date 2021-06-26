var InstapageDataFilter = function(options) {
  var scope = this;

  scope.options = options;
  scope.defaults = {
    single: '.js-filter-single',
    checkbox: '.js-filter-checkbox',
    select: '.js-filter-select',
    group: '.js-filter-group',
    thumbnailGroup: '.v7-thumbnails-group.js-filter-group',
    element: '.js-filter-group > .js-filter-element',
    selectedCategory: [],
    selectedValue: [],
    animationDuration: 350,
    scrollMargin: 120,
    animationEffect: 'fade-effect',
    stateActive: 'active',
    noResults: '.js-no-results',
    isHiddenClass: 'v7-is-hidden',
    isFilteredClass: 'v7-is-filtered'
  };
  scope.operators = ['>=', '<=', '=', '>', '<'];

  Object.assign(scope, _.extend(scope.defaults, scope.options));

  scope.init = function() {
    if (
      !jQuery(this.group).length ||
      (!jQuery(this.single).length && !jQuery(this.checkbox).length && !jQuery(this.select).length)
    ) {
      return false;
    }

    bindEventListeners();

    // Fired on jQuery(document).ready to auto-select a filter
    if (location.hash !== '#' && location.hash.length) {
      var checkboxFilters = null;
      var singleFilters = null;
      var selectFilters = null;

      category = location.hash.slice(1);
      checkboxFilters = jQuery(scope.checkbox + "[data-category='" + category + "']");

      if (checkboxFilters.length) {
        checkboxFilters[0].click();
        return true;
      }

      singleFilters = jQuery(scope.single + "[data-category='" + category + "']");

      if (singleFilters.length) {
        singleFilters[0].click();
        return true;
      }

      selectFilters = jQuery(scope.select + " option[data-category='" + category + "']");

      if (selectFilters.length) {
        selectFilters[0].click();
        return true;
      }
    }
  };

  function bindEventListeners() {
    jQuery(scope.single).on('click', singleFilter);
    jQuery(scope.checkbox).on('click', multiFilter);
    jQuery(scope.select).on('change', selectFilter);
  }

  /**
   * Filters only 1 category of items.
   */
  function singleFilter(event) {
    var $element = jQuery(event.currentTarget);
    var category = $element.data('category');
    var dataScroll = $element.attr('data-scroll');

    if (dataScroll !== undefined && jQuery.isNumeric(dataScroll)) {
      scope.scrollMargin = dataScroll;
    }

    if(!scope.thumbnailGroup) {
      jQuery('html, body').animate({
        scrollTop: jQuery(scope.group).offset().top - scope.scrollMargin
      }, scope.animationDuration + 50);
    }

    jQuery(scope.single).removeState(scope.stateActive);
    $element.addState(scope.stateActive);

    scope.filterAnimation(function() {
      scope.selectedCategory = [];
      scope.addCategoryFilter(category);
      scope.filter();
    });

    scrollTop();
  }

  /**
   * Adds multiple filter values to array.
   */
  function multiFilter(event) {
    var $element = jQuery(event.currentTarget);
    var category = $element.data('category');
    var value = $element.data('value');

    scope.filterAnimation(function() {
      if ($element.is(':checked')) {
        scope.addCategoryFilter(category);
        scope.addValueFilter(value);
      } else {
        scope.removeCategoryFromFilter(category);
        scope.removeValueFromFilter(value);
      }
      scope.filter();
    });
  }

  /**
   * Filters items based on data from select.
   */
  function selectFilter(event) {
    var $element = jQuery(event.currentTarget);
    var category = $element.find(':selected').data('category');
    var value = $element.find(':selected').data('value');

    scope.filterAnimation(function() {
      scope.addCategoryFilter(category);
      scope.removeCategoryFromFilter($element.data('category'));
      scope.addValueFilter(value);
      scope.removeValueFromFilter($element.data('value'));
      scope.filter();
      $element.data('category', category);
      $element.data('value', value);
    });
  }

  function scrollTop() {
    jQuery('html, body').animate({
      scrollTop: jQuery('#top').offset().top - 150
    }, 500);
  }

  scope.filterAnimation = function(callback) {
    jQuery(scope.group).addClass(scope.animationEffect);
    setTimeout(function() {
      callback();
      jQuery(scope.group).removeClass(scope.animationEffect);
    }, scope.animationDuration);
  }

  scope.filter = function(el) {
    jQuery(scope.element).each(function() {
      var element = jQuery(this);

      var data = element.data('filter').split(' ');
      var dataFilters = data.filter(function(element) {
        return scope.getOperator(element);
      });
      var dataCategories = _.difference(data, dataFilters);
      var tableFilter = _.intersection(scope.selectedCategory, dataCategories);

      if (_.difference(scope.selectedCategory, tableFilter).length === 0 && scope.checkFilters(dataFilters)) {
        // Make sure dynamic search and double filter don't cancel each other out
        if (!element.hasClass('v7-is-searched')) {
          element.removeClass(scope.isHiddenClass + ' ' + scope.isFilteredClass);
        } else {
          element.removeClass(scope.isFilteredClass);
        }
      } else {
        element.addClass(scope.isHiddenClass + ' ' + scope.isFilteredClass);
      }
      scope.displayNoResults();
    });
    // Recalculate integratons corners on hiding
    if (jQuery('.post-type-archive-integration').length) {
      integrationsUIHelper.hideCategories();
      integrationsUIHelper.calculateVisible();
    }
  };

  scope.getOperator = function(text) {
    var operator = '';
    scope.operators.some(function checkForOperator(element) {
      if (text.indexOf(element) !== -1) {
        operator = element;
        return true;
      }
    });

    return operator;
  }

  scope.checkFilters = function(filters) {

    var success = true;

    //Checks every value filter selected by the user.
    scope.selectedValue.forEach(function checkSingleValueFilter(selectedFilter) {

      // Compares the filter value with data stored in data-value attribute. All of the requirements has to be met to mark an item as ready to display.
      success = success && filters.some(function checkSingleValue(element) {
        var elementParts = scope.getFilterParts(element);
        var filterParts = scope.getFilterParts(selectedFilter);

        if (elementParts.argument1 === filterParts.argument1) {
          return scope.compareValues(elementParts.argument2, filterParts.argument2, filterParts.operator);
        }
        return false;
      });
    });

    return success;
  }

  scope.compareValues = function(value1, value2, operator) {
    if (!value1 || !value2) {
      return false;
    }

    switch(operator) {
      case '=':
        return parseFloat(value1) == parseFloat(value2);

      case '>=':
        return parseFloat(value1) >= parseFloat(value2);

      case '<=':
        return parseFloat(value1) <= parseFloat(value2);

      case '>':
        return parseFloat(value1) > parseFloat(value2);

      case '<':
        return parseFloat(value1) < parseFloat(value2);

      default:
        return false;
    }
  }

  scope.getFilterParts = function(filterText) {
    var operator = scope.getOperator(filterText);
    var filterArray = [];

    if (operator) {
      filterArray = filterText.split(operator);
      return { argument1: filterArray[0], argument2: filterArray[1], operator: operator };
    }

    return null;
  }

  scope.addCategoryFilter = function(text) {
    if (text && text !== 'all') {
      scope.selectedCategory.push(text);
    }
  }

  scope.removeCategoryFromFilter = function(text) {
    if (text) {
      scope.selectedCategory = scope.selectedCategory.filter(function(e) { return e !== text; });
    }
  }

  scope.addValueFilter = function(text) {
    if (text) {
      scope.selectedValue.push(text);
    }
  }

  scope.removeValueFromFilter = function(text) {
    if (text) {
      scope.selectedValue = scope.selectedValue.filter(function(e) { return e !== text; });
    }
  }

  scope.displayNoResults = function() {
    if (jQuery(scope.group).find('.v7-is-hidden').length === jQuery(scope.group).children().length) {
      jQuery(scope.noResults).removeClass(scope.isHiddenClass);
    } else {
      jQuery(scope.noResults).addClass(scope.isHiddenClass);
    }
  }
};
