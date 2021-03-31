# This is my package LaravelRestable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/binarcode/laravel_restable.svg?style=flat-square)](https://packagist.org/packages/binarcode/laravel_restable)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/binarcode/laravel_restable/run-tests?label=tests)](https://github.com/binarcode/laravel_restable/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/binarcode/laravel_restable/Check%20&%20fix%20styling?label=code%20style)](https://github.com/binarcode/laravel_restable/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/binarcode/laravel_restable.svg?style=flat-square)](https://packagist.org/packages/binarcode/laravel_restable)

Lightweight package for a Laravel Rest API getters.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/package-laravel_restable-laravel.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/package-laravel_restable-laravel)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require binarcode/laravel_restable
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="BinarCode\LaravelRestable\LaravelRestableServiceProvider" --tag="laravel_restable-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="BinarCode\LaravelRestable\LaravelRestableServiceProvider" --tag="laravel_restable-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel_restable = new BinarCode\LaravelRestable();
echo $laravel_restable->echoPhrase('Hello, Spatie!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Eduard Lupacescu](https://github.com/BinarCode)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
