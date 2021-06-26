/* Basic usage:
- render search PHP component
- add "js-search-content" id to the content that need to be filtered
- all filtered elements within the content should have
  - "js-search-element" class
  - "data-search" attribute with proper data
*/

var InstapageSearch = function(options) {
  this.options = options || {};
  this.defaults = {
    inputElement: jQuery('.js-search'),
    selectorFilteredElement: '.js-search-element',
    searchContentNode: jQuery('.js-search-content'),
    contentArray: [],
    doubleColumnLayout: 'v7-template-dual-column-right',
    doubleColumnTopbarArea: 'v7-template-dual-column-topbar'
  };
  Object.assign(this, _.extend(this.defaults, this.options));
};

InstapageSearch.prototype.init = function () {
  if (!this.inputElement.length) {
    return false;
  }

  // Let's get all content and put it into an array.
  this.getArrayContent();
  // Also create a DOM element for the empty content message.
  this.createEmptyContentBox();

  // Autocomplete plugin. We can make it optionalble in the future.
  this.autocomplete();

  // The whole functionality goes to "keyup", "change" and custom "autocomplete" event.
  this.inputElement.on('keyup change autocomplete', (function () {
    // Here is the core of search function.
    this.searchMagic();
    if(jQuery('.post-type-archive-feature')) {
      this.showHideProductBlock();
    }
    if (jQuery('.post-type-archive-integration').length) {
      integrationsUIHelper.calculateVisible();
    }
    // We can make it optionable in the future.
    this.removeEmptyCategory();
  }).bind(this));
};

InstapageSearch.prototype.showHideProductBlock = function () {
  var $tilesSection = jQuery('.js-tile-section');
  var $searchContent = jQuery('.js-search-content');
  var $searchEmptyBox = jQuery('.search-empty-box');
  var $searchHeading = jQuery('.js-search-heading');
  var $searchCategories = jQuery('.js-sidebar');
  var $searchKeyword = jQuery('.js-search-keyword');
  //Check if search input has any value
  if (this.inputElement.val()) {
    $tilesSection.hide();
    $searchHeading.show();
    // For components like accordions within grid template
    if ($searchContent.hasClass(this.doubleColumnLayout)) {
      $searchContent.addClass(this.doubleColumnTopbarArea);
      $searchEmptyBox.addClass(this.doubleColumnTopbarArea);
    }
    $searchCategories.addClass('is-searched');
    $searchKeyword.text(this.inputElement.val());
  } else {
    $tilesSection.show();
    // For components like accordions within grid template
    if ($searchContent.hasClass(this.doubleColumnLayout)) {
      $searchContent.removeClass(this.doubleColumnTopbarArea);
      $searchEmptyBox.removeClass(this.doubleColumnTopbarArea);
    }
    $searchCategories.removeClass('is-searched');
    $searchHeading.hide();
  }
};

InstapageSearch.prototype.getArrayContent = function () {
  var array = [];
  var value;
  this.searchContentNode.find(this.selectorFilteredElement).each(function () {
    value = jQuery(this).attr('data-search');
    array.push(value);
  });
  this.contentArray = array;
};

InstapageSearch.prototype.createEmptyContentBox = function () {
  this.emptyContentMessageBox = document.createElement('div');
  this.emptyContentMessageBox.className = 'search-empty-box division-bottom';
  this.emptyContentMessageBox.innerHTML = '<h3>Unfortunately, there are no results.</h3>';
}

InstapageSearch.prototype.searchMagic = function () {
  var value = this.inputElement.val().toLowerCase();
  this.searchContentNode.find(this.selectorFilteredElement).each(function () {
    if (jQuery(this).attr('data-search').toLowerCase().indexOf(value) === -1) {
      // Specify dynamic search and make sure double filter doesn't cancel it out
      jQuery(this).addClass('v7-is-hidden v7-is-searched');
    } else if (!jQuery(this).hasClass('v7-is-filtered')) {
      jQuery(this).removeClass('v7-is-hidden v7-is-searched');
    } else {
      jQuery(this).removeClass('v7-is-searched');
    }
  });
};

InstapageSearch.prototype.removeEmptyCategory = function () {
  var selectorFilteredElement = this.selectorFilteredElement;
  var areContentVisible = false;

  if (jQuery('.post-type-archive-integration').length) {
    jQuery('.js-no-results').addClass('v7-is-hidden');
  } else {
    jQuery(this.emptyContentMessageBox).remove();
  }

  this.searchContentNode.children().each(function () {
    var elements = jQuery(this).find(selectorFilteredElement);
    var hiddenElements = jQuery(this).find(selectorFilteredElement + '.v7-is-hidden');
    if (hiddenElements.length === elements.length) {
      jQuery(this).addClass('is-hidden');
    } else {
      jQuery(this).removeClass('is-hidden');
      areContentVisible = true;
    }
  });

  if (!areContentVisible) {
    if (jQuery('.post-type-archive-integration').length) {
      jQuery('.js-no-results').removeClass('v7-is-hidden');
    } else {
      jQuery(this.emptyContentMessageBox).insertBefore(this.searchContentNode);
    }
    jQuery('.js-search-heading').hide();
  }
};

InstapageSearch.prototype.autocomplete = function () {
  autocomplete(this.contentArray)
}
