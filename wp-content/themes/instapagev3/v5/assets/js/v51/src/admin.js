jQuery(document).ready(function ($) {

  var UserHelper = function UserHelper() {
    this.addUserFormSelector = '#createuser';
    this.addRequiredFields = {
      firstNameSelector: '#first_name',
      lastNameSelector: '#last_name'
    };
    this.editUserFormSelector = '#your-profile';
    this.editRequiredFields = {
      firstNameSelector: '#first_name',
      lastNameSelector: '#last_name',
      nicknameSelector: '#nickname'
    };

    this.initUserForms = function () {
      if (this.isEditUserForm()) {
        this.bindEditUserFormSubmit();
      }

      if (this.isAddUserForm()) {
        this.bindAddUserFormSubmit();
      }
    };

    this.isEditUserForm = function () {
      return $(this.editUserFormSelector).length;
    };

    this.isAddUserForm = function () {
      return $(this.addUserFormSelector).length;
    };

    this.bindEditUserFormSubmit = function () {
      $(userHelper.editUserFormSelector).on('submit', function (e) {
        var valid = true;

        $.each(userHelper.editRequiredFields, function (i, field) {
          var label = userHelper.getFormFieldLabel(field);
          var value = $(field).val().trim();

          if (!value.length) {
            alert(label + ' is required');
            $(field).focus();
            valid = false;
          }
        });

        if (!valid) {
          e.preventDefault();
        }
      });
    };

    this.bindAddUserFormSubmit = function () {
      $(userHelper.addUserFormSelector).on('submit', function (e) {
        var valid = true;

        $.each(userHelper.addRequiredFields, function (i, field) {
          var label = userHelper.getFormFieldLabel(field);
          var value = $(field).val().trim();

          if (!value.length) {
            alert(label + ' is required');
            $(field).focus();
            valid = false;
          }
        });

        if (!valid) {
          e.preventDefault();
        }
      });
    };

    this.getFormFieldLabel = function (fieldSelector) {
      if (!$(fieldSelector).length) {
        return false;
      }

      var label = $(fieldSelector).parents('tr').find('label');
      if (!label.length) {
        return false;
      }

      return label.text().replace(/ \(required\)/g, '');
    };
  };

  var userHelper = new UserHelper();
  userHelper.initUserForms();
});
