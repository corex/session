# Session (Namespace, Page, Token, ...)

**_Versioning for this package follows http://semver.org/. Backwards compatibility might break on upgrade to major versions._**


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
