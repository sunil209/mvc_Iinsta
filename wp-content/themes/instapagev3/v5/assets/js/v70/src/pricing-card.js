var InstapagePricingCard = function(options) {
  this.defaults = {
    hiddenClass: 'v7-is-hidden',
    transparentClass: 'v7-is-transparent',
    openClass: 'v7-pricing-card-expanded',
    clickedClass: 'v7-icon-clicked',
    switchedClass: 'is-switched',
    selector: {
      expandHandle: '.js-expand-card-link',
      expandHandleText: '.js-expand-card-link span',
      toggleHandle: '.js-toggle-switch',
      pricingCard: '.v7-pricing-card',
      price: '.v7-price',
      toggleDescription: '.v7-toggle-option-description'
    }
  };
  Object.assign(this, _.extend(this.defaults, options || {}));
};

InstapagePricingCard.prototype.init = function () {
  jQuery(this.selector.expandHandle).on('click', (this.toggleCardAndExpandHandle).bind(this));
  jQuery(this.selector.toggleHandle).on('click', (this.togglePrice).bind(this));
  jQuery(this.selector.toggleDescription).on('click', (this.togglePrice).bind(this));
};

InstapagePricingCard.prototype.toggleCardAndExpandHandle = function () {
  var $pricingCard = jQuery(this.selector.pricingCard);
  var $expandHandle = jQuery(this.selector.expandHandle);
  var $expandHandleText = jQuery(this.selector.expandHandleText);

  $expandHandle.toggleClass(this.clickedClass);
  this.toggleButtonText($expandHandleText);

  $pricingCard.toggleClass(this.openClass);
}

InstapagePricingCard.prototype.toggleButtonText = function (button) {
  var buttonText;

  if (button[0].textContent == 'SEE ALL FEATURES') {
    buttonText = 'SEE LESS FEATURES'
  } else if (button[0].textContent == 'SEE LESS FEATURES') {
    buttonText = 'SEE ALL FEATURES'
  }

  button[0].textContent = buttonText;
}

InstapagePricingCard.prototype.togglePrice = function () {
  var $price = jQuery(this.selector.price);
  var $toggleDescription = jQuery(this.selector.toggleDescription);
  var $toggleSwitch = jQuery(this.selector.toggleHandle);

  $price.toggleClass(this.transparentClass);
  $toggleDescription.toggleClass(this.switchedClass);
  $toggleSwitch.toggleClass(this.switchedClass);
}
