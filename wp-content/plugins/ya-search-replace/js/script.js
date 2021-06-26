(function($) {
  $(document).ready(function() {

    $('.search-box').on('submit', function(e) {
      var form = this;
      var fields = ['yasr-search', 'yasr-replace'];
      $.each(fields, function(i, field) {
        if (!$(form)
            .find('input[name=' + field + ']')
            .val()
            .trim()
            .length) {
          alert('You have to fill both values');
          e.preventDefault();
          return false;
        }
      });

      if ($(form).find('input[name=' + fields[0] + ']').val().trim() ==
          $(form).find('input[name=' + fields[1] + ']').val().trim()) {
        alert('Search and Replace values have to be different');
          e.preventDefault();
          return false;
      }

    });

    $('.results-box').on('submit', function(e) {
      if (!$(this)
          .find('.checkbox_post:checked')
          .length) {
        e.preventDefault();
        alert('You have to select at least one page/post');
        return false;
      }
    });

    $('.extended-results-box').on('submit', function(e) {
      if (!$(this)
          .find('.checkbox_post:checked')
          .length) {
        e.preventDefault();
        alert('You have to select at least one page/post');
        return false;
      }

      return confirm('Are you sure that you want to make these changes?');
    });

    $('.backups-box').on('submit', function(e) {
      if (!$(this)
          .find('.checkbox_post:checked')
          .length) {
        e.preventDefault();
        alert('You have to select at least one backup to revert');
        return false;
      }

      return confirm('Are you sure that you want to revert those changes?');
    });
  });
}(jQuery));
