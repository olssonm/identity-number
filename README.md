# Swedish "personnummer" validator for Laravel 5

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]

Validator for Swedish "personnummer" (a.k.a. personal identity number, social security number or simply "PIN").

This validator also handles Swedish organization numbers and the temporary personal identity number known as "Samordningsnummer" (a.k.a. coordination number).

For use either as a standalone package, or with Laravel 5.

The package does not only apply the Luhn-algorithm for the last four digits, but also checks that the date of birth is a valid date.

Of course you can throw pretty much any format you wish at the validator, ie. 10-digit variant (`7712112775`) or the 12-digit variant (`197712112775`) and with or without a hyphen (`771211-2775`, `19771211-2775`).

## Version Compatibility

 Laravel                               | identity-number
:--------------------------------------|:----------
 `5.1.x` / `5.2.x`                     | `2.x`
 <code>>=5.3.x &#124; <=5.7.x</code>   | `^5.x`
 `>=5.8.x`                             | `^6.x`

*Note: please check the corresponding readme.md for the correct documentation for each version.*

## Install

Via Composer

``` bash
$ composer require olssonm/identity-number
```

**Together with Laravel**

Since v5.* (for Laravel 5.5) this package uses Package Auto-Discovery for loading the service provider. Once installed you should see the message

```
Discovered Package: olssonm/identity-number
```

Else, per standard Laravel-procedure, just register the package in your providers array:

``` php
'providers' => [
    Olssonm\IdentityNumber\IdentityNumberServiceProvider::class,
]
```

## Usage

### Standalone

The package is usable straight out of the box once installed with composer:

``` php
use Olssonm\IdentityNumber\Pin;
```

#### Personnummer ("personal identity number")

``` php
Pin::isValid('19771211-2775'); // Defaults to identity number
// true

Pin::isValid('19771211-2775', 'identity'); // Identity validation specified
// true
```

#### Organisationsnummer ("organization number")

``` php
Pin::isValid('556016-0681', 'organization')
// True
```

#### Samordningsnummer ("coordination number")

``` php
Pin::isValid('19671180-2850', 'coordination');
// True
```

The coordination-number validator handles the same way as the personal identity-validator but does run a check on the birthdate.

### The IdentityNumberFormatter-class

The IdentityNumberFormatter-class allows you to format a PIN/identity for your custom needs. The class is also used internally for validation, but if you want to make sure you save the same value in the database as you pass for validation – you should also apply the formatting before validating.

```php

use Olssonm\IdentityNumber\IdentityNumberFormatter;

// Format to a 10-character PIN without a seperator
$formatter = new IdentityNumberFormatter('19860210-7313', 10, false);

// Get the formatted output
$formatter->getFormatted(); // 8602107313

// You can also clean the number from all unwanted characters
(new IdentityNumberFormatter('a19860210 - 7313', 12, true))->clean()->getFormatted(); // 19860210-7313
```

### Laravel 5 validators

The package extends the `Illuminate\Validator` via a service provider, so all you have to do is use the `identity_number`-, `coordination_number`- and `organization_number`-rules, just as you would with any other rule.

``` php
// Personal identity numbers
public function store(Request $request) {
    $this->validate($request, [
        'number' => 'required|identity_number'
    ]);
}

// Coordination numbers
public function store(Request $request) {
    $this->validate($request, [
        'number' => 'required|coordination_number'
    ]);
}

// Organization numbers
public function store(Request $request) {
    $this->validate($request, [
        'number' => 'required|organization_number'
    ]);
}
```

And of course, you can roll your own error messages:

``` php
$validator = Validator::make($request->all(), [
    'number' => 'required|identity_number'
], [
    'number.identity_number' => "Hey! That's not a personnummer!"
]);

if($validator->fails()) {
    return $this->returnWithErrorAndInput($validator);
}
```

If you're using the validation throughout your application, you also might want to put the error message in your lang-files.

## Testing

``` bash
$ composer test
```

or

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

© 2018 [Marcus Olsson](https://marcusolsson.me).

[ico-version]: https://img.shields.io/packagist/v/olssonm/identity-number.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/olssonm/identity-number/master.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/olssonm/identity-number
[link-travis]: https://travis-ci.org/olssonm/identity-number
