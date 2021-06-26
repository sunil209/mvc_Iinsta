Instapage = function () { };

Instapage.prototype.init = function() {
  this.utilities();
  this.scrollToElement();
  this.navbarStick();
  this.search();
  this.podcast();
  this.cookie();
  this.dataFilter();
  this.countdown();
  this.select();
  this.modal();
  this.input();
  this.snackbar();
  this.expandAccordion();
  this.expandItem();
  this.pricingCard();
  this.networkStatus();
  this.video();
  this.validation();
  this.slickSlider();
  this.segmentLoader();

  // trigger custom event, for other scripts
  // to know that instapage environment has loaded properly
  jQuery(document).trigger('instapage_loaded');
};

Instapage.prototype.scrollToElement = function () {
  if (!this.hasOwnProperty('scrollToElement')) {
    this.scrollToElement = new InstapageScrollToElement({});
    this.scrollToElement.init();
  }
};

Instapage.prototype.navbarStick = function () {
  if (!this.hasOwnProperty('navbarSticky')) {
    this.navbarSticky = new InstapageNavbarSticky({});
    this.navbarSticky.init();
  }
};

Instapage.prototype.cookie = function () {
  if (!this.hasOwnProperty('cookie')) {
    this.cookie = new InstapageCookie({});
  }
};

Instapage.prototype.search = function () {
  if (!this.hasOwnProperty('search')) {
    this.search = new InstapageSearch();
    this.search.init();
  }
};

Instapage.prototype.dataFilter = function () {
  if (!this.hasOwnProperty('dataFilter')) {
    this.dataFilter = new InstapageDataFilter({});
    this.dataFilter.init();

    this.dataFilter2 = new InstapageDataFilter({
      single: '.js-filter-single2',
      checkbox: '.js-filter-checkbox2',
      select: '.js-filter-select2',
      group: '.js-filter-group2',
      element: '.js-filter-group2 > .js-filter-element2',
      noResults: '.js-no-results2'
    });
    this.dataFilter2.init();
  }
};

Instapage.prototype.countdown = function () {
  if (!this.hasOwnProperty('countdown')) {
    this.countdown = new InstapageCountdown({});
    this.countdown.init();
  }
};

Instapage.prototype.segmentLoader = function() {
  if(!this.hasOwnProperty('segmentLoader')) {
    this.segmentLoader = new SegmentLoader();
    this.segmentLoader.init();
  }
};

Instapage.prototype.select = function() {
  if (!this.hasOwnProperty('select')) {
    this.select = new InstapageSelect({});
    this.select.init();
  }
};

Instapage.prototype.modal = function () {
  if (!this.hasOwnProperty('modal')) {
    this.modal = new InstapageModal({});
    this.modal.init();
  }
};

Instapage.prototype.input = function () {
  if (!this.hasOwnProperty('input')) {
    this.input = new InstapageInput({});
    this.input.init();

    this.inputV7 = new InstapageInput({
      selectorInput: '.js-v7-input-field',
      selectorMessage: '.js-v7-input-info',
      selectorClear: '.js-v7-input-clear',
      selectorForm: '.js-v7-search-form',
      selectorSearch: '.js-v7-input-search',
      errorState: 'is-error'
    });
    this.inputV7.init();
  }
};

Instapage.prototype.podcast = function () {
  if (!this.hasOwnProperty('podcast')) {
    this.podcast = InstapagePlayer();
  }
};

Instapage.prototype.snackbar = function () {
  if (!this.hasOwnProperty('snackbar')) {
    this.snackbar = new InstapageSnackbar({});
    this.snackbar.init();
  }
};

Instapage.prototype.expandItem = function () {
  if (!this.hasOwnProperty('expandItem')) {
    this.expandItem = new InstapageExpandItem({});
    this.expandItem.init();
  }
};

Instapage.prototype.expandAccordion = function () {
  if (!this.hasOwnProperty('expandAccordion')) {
    this.expandAccordion = new InstapageExpandAccordion();
    this.expandAccordion.init();
  }
};

Instapage.prototype.pricingCard = function () {
  if (!this.hasOwnProperty('pricingCard')) {
    this.pricingCard = new InstapagePricingCard();
    this.pricingCard.init();
  }
};

Instapage.prototype.networkStatus = function () {
  if (!this.hasOwnProperty('networkStatus')) {
    this.networkStatus = new InstapageNetworkStatus();
    this.networkStatus.init();
  }
};

Instapage.prototype.video = function () {
  if (!this.hasOwnProperty('video')) {
    this.video = new InstapageVideo({});
    this.video.init();
  }
};

Instapage.prototype.validation = function () {
  if (!this.hasOwnProperty('validation')) {
    this.validation = new InstapageValidation({});
    this.validation.init();
  }
};

Instapage.prototype.slickSlider = function () {
  if (!this.hasOwnProperty('slickSlider')) {
    this.slickSlider = new InstapageSlickSlider({});
    this.slickSlider.init();
  }
};

Instapage.prototype.utilities = function() {
  if (!this.hasOwnProperty('utilities')) {
    this.utilities = new InstapageUtilities();
  }
}

var instapage;
jQuery(document).ready(function () {
  instapage = new Instapage();
  instapage.init();
});
