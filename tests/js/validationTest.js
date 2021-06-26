QUnit.module('InstapageValidation (email)');

QUnit.test('Valid', function(assert) {
  var emails = [
    'email@example.com',
    'firstname.lastname@example.com',
    'email@subdomain.example.com',
    'firstname+lastname@example.com',
    '1234567890@example.com',
    'email@example-one.com',
    '_______@example.com',
    'email@example.name',
    'email@example.museum',
    'email@example.co.jp',
    'firstname-lastname@example.com'
  ];
  for (var i = 0, l = emails.length; i < l; i++) {
    assert.ok(
      instapage.validation.emailIsValid(emails[i]),
      emails[i] + " is valid email address."
    );
  }
});

QUnit.test('Invalid', function(assert) {
  var emails = [
    'plainaddress',
    '#@%^%#$@#$@#.com',
    '@example.com',
    'Joe Smith <email@example.com>',
    'email.example.com',
    'email@example@example.com',
    '.email@example.com',
    'email.@example.com',
    'email..email@example.com',
    'email@example.com (Joe Smith)',
    'email@example',
    'email@111.222.333.44444',
    'email@example..com',
    'Abc..123@example.com'
  ];
  for (var i = 0, l = emails.length; i < l; i++) {
    assert.notOk(
      instapage.validation.emailIsValid(emails[i]),
      emails[i] + " is NOT valid email address, but that's expected."
    );
  }
});

QUnit.module('InstapageValidation (url)');

QUnit.test('Valid', function(assert) {
  var urls = [
    'foo.bar',
    'foo.bar/',
    'foo.bar:8080',
    'foo.bar:8080/',
    'ftp://foo.bar',
    'ftp://foo.bar/',
    'http://foo.bar',
    'http://foo.bar/',
    'https://foo.bar',
    'https://foo.bar/',
    'ftp://foo.bar:8080',
    'ftp://foo.bar:8080/',
    'http://foo.bar:8080',
    'http://foo.bar:8080/',
    'https://foo.bar:8080',
    'https://foo.bar:8080/',
    '127.0.0.1',
    '127.0.0.1:8080',
    '127.0.0.1:8080/',
    'ftp://127.0.0.1',
    'ftp://127.0.0.1/',
    'http://127.0.0.1',
    'http://127.0.0.1/',
    'https://127.0.0.1',
    'https://127.0.0.1/',
    'ftp://127.0.0.1:8080',
    'ftp://127.0.0.1:8080/',
    'http://127.0.0.1:8080',
    'http://127.0.0.1:8080/',
    'https://127.0.0.1:8080',
    'https://127.0.0.1:8080/',
    'aa.czemu.to.nie.dziala.hmmm'
  ];
  for (var i = 0, l = urls.length; i < l; i++) {
    assert.ok(
      instapage.validation.urlIsValid(urls[i]),
      urls[i] + " is valid url"
    );
  }
});

QUnit.test('Invalid', function(assert) {
  var urls = [
    'a',
    'a.b',
    'foo',
    'abcdef',
    'localhost',
    'foo..bar',
    '.foo.bar',
    '..foo.bar/',
    '127.1234.0.1',
    '127.0.0.1:8',
    '127.0.0.1::8080/',
    'gopher://127.0.0.1:8080/'
  ];
  for (var i = 0, l = urls.length; i < l; i++) {
    assert.notOk(
      instapage.validation.urlIsValid(urls[i]),
      urls[i] + " is NOT valid url, but that's expected."
    );
  }
});
