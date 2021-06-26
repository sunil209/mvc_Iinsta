var InstapageCookie = function() {
  var scope = this;

  scope.setCookie = function(name, value, days, domain) {
    var expires = '';
    var domainValue = '';
    
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = '; expires=' + date.toUTCString();
    }

    if (domain) {
      domainValue = ";domain=" + domain;
    }

    document.cookie = name + '=' + value + expires + domainValue + '; path=/';
  };

  scope.getCookie = function(name) {
    var namePrefix = name + '=';
    var cookies = document.cookie.split(';');
    for (var i = 0, c = cookies.length; i < c; i++) {
      var cookie = cookies[i];
      while (cookie.charAt(0) === ' ') {
        cookie = cookie.substring(1, cookie.length);
      }
      if (cookie.indexOf(namePrefix) === 0) {
        return cookie.substring(namePrefix.length, cookie.length);
      }
    }
    return null;
  };

  scope.removeCookie = function(name) {
    scope.setCookie(name, '', -1);
  };
};
