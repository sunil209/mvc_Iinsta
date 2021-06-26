var InstapageValidation = function(options) {
  this.options = options;
  this.defaults = {
    formValidationSelector: '.js-form-validation',
    formInputSelector: '.v7-input-field'
  };
  Object.assign(this, _.extend(this.defaults, this.options));
}

InstapageValidation.prototype.init = function() {
  var scope = this;

  if (!jQuery(scope.formValidationSelector)[0]) {
    return false
  }

  jQuery(scope.formValidationSelector).on('submit', scope.formValidation.bind(scope));
}

InstapageValidation.prototype.formValidation = function(e) {
  var scope = this;
  var $fields = jQuery(e.target).find(scope.formInputSelector);
  var valid = scope.validateFields($fields);

  if (!valid) {
    e.preventDefault();
  } else {
    var validationSuccessfullEvent = new Event('form:validationsucessfull');
    e.target.dispatchEvent(validationSuccessfullEvent);
  }
};


InstapageValidation.prototype.validateFields = function($fields) {
  var valid = true;

  if ($fields.length > 0) {
    _.each($fields, function(field) {
      if (!instapage.input.isValid(field)) {
        valid = false;
      }
    });
  }

  return valid;
};

InstapageValidation.prototype.emailIsValid = function(value) {
  var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}])|(([a-z\-0-9]+\.)+[a-z]{2,}))$/i;
  return ((value.length <= 120) && (pattern.test(value)));
}

InstapageValidation.prototype.urlIsValid = function(value) {
  var pattern = /^((ftp|http|https):\/\/)?((([a-z0-9_-]+)(\.[a-z0-9_-]{2,})+(\.[a-z]{2,})?)|((\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})))(\:\d{2,5})?\/?/i;
  return pattern.test(value);
}
