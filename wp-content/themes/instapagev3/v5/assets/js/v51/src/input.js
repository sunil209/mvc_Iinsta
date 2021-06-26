var InstapageInput = function(options) {
  this.options = options;
  this.defaults = {
    selectorInput: '.input-field',
    selectorMessage: '.input-info',
    selectorClear: '.input-clear',
    selectorForm: '.js-search-form',
    selectorSearch: '.js-input-search',
    selectorRadio: '.js-input-radio',
    errorState: 'is-error',
    nonBusinessEmailsSubStrings: [
      '.website',
      '@bizcomail.',
      '@eigoemail.',
      '@gmail.',
      '@google.',
      '@hotmail.',
      '@jetsmails.',
      '@jmail7.',
      '@live.',
      '@mail.',
      '@mailboxt.',
      '@me.',
      '@msn.',
      '@outlook.',
      '@xmailsme.',
      '@yahoo.',
      '@yopmail.',
      '@p5mail.com',
      '@aol.com'
    ]
  };
  Object.assign(this, _.extend(this.defaults, this.options));
};

InstapageInput.prototype.init = function() {
  if (!jQuery(this.selectorInput)[0]) {
    return false;
  }
  var scope = this;
  jQuery(scope.selectorInput).on('blur keyup change', function() {
    scope.isValid(this);
  });

  jQuery(scope.selectorClear).on('click', function() {
    scope.clearInput();
  });

  this.bindEventsToSearch();
  this.showGdprInfo();
};

InstapageInput.prototype.clearInput = function() {
  var scope = this;
  if(jQuery(scope.selectorInput).hasClass('input-clear-field')){
     jQuery(scope.selectorInput).val('');
  }
  scope.isValid(scope.selectorInput);
};

InstapageInput.prototype.validateSearchInput = function(input) {
  var required = jQuery(input).attr('required') || false;
  var value = jQuery(input).val().trim();

  if (required && value.length === 0) {
    jQuery(input).closest('form').find(this.selectorSearch).attr('disabled', true);
  } else {
    jQuery(input).closest('form').find(this.selectorSearch).attr('disabled', false);
  }
};

InstapageInput.prototype.searchInput = function() {
  return jQuery(this.selectorForm + ' ' + this.selectorInput);
}

InstapageInput.prototype.bindEventsToSearch = function() {
  jQuery(window).ready((function() {
    this.searchInput().each((function(index, element) {
      this.validateSearchInput(element);
    }).bind(this));
  }).bind(this));

  this.searchInput().on('blur keyup change', (function(event) {
    this.validateSearchInput(jQuery(event.target));
  }).bind(this));
}

InstapageInput.prototype.isValid = function(element) {
  var scope = this;
  var $input = jQuery(element);
  var type = $input.attr('type') || 'text';
  var label = $input.data('name') || $input.attr('name');
  var required = $input.attr('required') || false;
  var requiredMessage = $input.data('required-message') || label + ' is required';
  var invalidMessage = $input.data('invalid-message') || label + ' is invalid';

  if (type === 'text' || type === 'password' || type === 'tel') {
    var value = $input.val().trim();
    if (required && value.length === 0) {
      scope.setValidationMessage(element, requiredMessage);
      return false;
    }
  } else if (type === 'email') {
    if ($input.data('validation') === 'businessEmail') {
      return scope.isBusinessEmail(element);
    }

    var value = $input.val().trim();
    if (required && value.length === 0) {
      scope.setValidationMessage(element, requiredMessage);
      return false;
    } else if (required && !instapage.validation.emailIsValid(value)) {
      scope.setValidationMessage(element, invalidMessage);
      return false;
    }
  } else if (type === 'url') {
    var value = $input.val().trim();
    if (required && value.length === 0) {
      scope.setValidationMessage(element, requiredMessage);
      return false;
    } else if (required && !instapage.validation.urlIsValid(value)) {
      scope.setValidationMessage(element, invalidMessage);
      return false;
    }
  } else if (type === 'checkbox') {
    if (required && !$input.is(':checked')) {
      scope.setValidationMessage(element, requiredMessage);
      return false;
    } else {
      $input.removeState(scope.errorState);
    }
  }

  scope.setValidationMessage(element, '');
  return true;
};

InstapageInput.prototype.isBusinessEmail = function (input) {
  var $input = jQuery(input);
  var invalidMessage = $input.data('invalid-message');
  var inputValue = $input.val().trim();
  var standardEmailRegex = /^.+@.+\..+$/g;

  var isValidBusinessEmail = standardEmailRegex.test(inputValue) && !this.isNonBussinessEmail(inputValue);

  if (!isValidBusinessEmail) {
    this.setValidationMessage(input, invalidMessage);
    return false;
  }

  this.setValidationMessage(input, '');
  return true;
};

InstapageInput.prototype.isNonBussinessEmail = function (email) {
  return this.nonBusinessEmailsSubStrings.some(function (nonBusinessEmailSubString) {
    return email.indexOf(nonBusinessEmailSubString) !== -1;
  });
};

InstapageInput.prototype.setValidationMessage = function(element, message) {
  var scope = this;

  jQuery(element).siblings(scope.selectorMessage).find('span:eq(0)').text(message);
  if (message.length > 0) {
    jQuery(element).addState(scope.errorState);
  } else {
    jQuery(element).removeState(scope.errorState);
  }
};

// Function binds to the selector and fires on click.
// Shows coresponding element and hide others, adds require prop to checkbox.
InstapageInput.prototype.showGdprInfo = function() {
  var gdprInfo = jQuery('.js-gdpr-info');
  var gdprInput = jQuery('.js-gdpr-info .js-v7-input-field');

  jQuery(this.selectorRadio).on('click', function() {
    gdprInfo.addClass('v7-is-hidden');
    jQuery('#' + this.value).removeClass('v7-is-hidden');
    gdprInput.prop('required', false);
    jQuery('#' + this.value + ' .js-v7-input-field').prop('required', true);
  });
};
