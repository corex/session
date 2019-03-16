# Session (Namespace, Page, Token, ...)

![License](https://img.shields.io/packagist/l/corex/session.svg)
![Build Status](https://travis-ci.org/corex/session.svg?branch=master)
![codecov](https://codecov.io/gh/corex/session/branch/master/graph/badge.svg)


### Session
Session handler.

A few examples.
```php
// Set session variable.
Session::set('actor', 'Roger Moore');

// Get session variable.
$actor = Session::get('actor');

// Check if session variable exists.
if (!Session::has('actor')) {
}
```


### Token
Token handler (uses Session handler).

A few examples.
```php
// Create csrf token.
$csrfToken = Token::create('csrf');

// Check csrf token.
if (!Token::isValid($csrfToken)) {
}
```
