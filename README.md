# Swedish "personnummer" validator for L5

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]

Validator for Swedish personal identity numbers, a.k.a. social security number ("personnummer") and organization numbers ("organisationsnummer").

For use either as a standalone package, or with Laravel 5.

The package does not only apply the Luhn-algorithm for the last four digits, but also checks that the date of birth is a valid date.

Of course you can throw any format you wish at the validator, ie. 10-digit variant (`7712112775`) or the 12-digit variant (`197712112775`) and with or without a hyphen (`19771211-2775`).

**Note:** Since 2.0 you may also validate Swedish organization numbers (organisationsnummer). Before this you could in most cases validate an org. no. with `personal_identity_number`, this is no longer possible due to tighter date validation on PINs. Please use `org_number` instead.

## Install

Via Composer

``` bash
$ composer require olssonm/identity-number
```

**Together with Laravel**

As standard Laravel-procedure, just register the package in your providers array:

``` php
'providers' => [
    Olssonm\IdentityNumber\IdentityNumberServiceProvider::class,
]
```

## Usage

#### Standalone

```php
use Olssonm\IdentityNumber\IdentityNumber as Pin;

Pin::isValid('19771211-2775'); // Validate PIN
// true

Pin::isValid('556016-0681', false); // Validate Org. No.
// true
```

The second parameters tells the validator if the date contained within the PIN/org. no. should be checked.

#### Laravel 5

The package extends the `Illuminate\Validator` via a service provider, so all you have to do is use the `personal_identity_number`- and `org_number`-rules, just as you would with any other rule.

``` php

// PIN
public function store(Request $request) {
    $this->validate($request, [
        'pnr' => 'required|personal_identity_number'
    ]);
}

// Org. no.
public function store(Request $request) {
    $this->validate($request, [
        'org_no' => 'required|org_number'
    ]);
}
```

Of course, you can roll your own error messages:

``` php
$validator = Validator::make($request->all(), [
    'pnr' => 'required|personal_identity_number'
], [
    'pnr.personal_identity_number' => "Hey! That's not a personnummer!"
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

© 2016 [Marcus Olsson](https://marcusolsson.me).

[ico-version]: https://img.shields.io/packagist/v/olssonm/identity-number.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/olssonm/identity-number/master.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/olssonm/identity-number
[link-travis]: https://travis-ci.org/olssonm/identity-number
