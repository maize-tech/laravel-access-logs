# Laravel Access Logs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maize-tech/laravel-access-logs.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-access-logs)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/maize-tech/laravel-access-logs/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/maize-tech/laravel-access-logs/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/maize-tech/laravel-access-logs/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/maize-tech/laravel-access-logs/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/maize-tech/laravel-access-logs.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-access-logs)

Easily log users access into your application.

## Installation

You can install the package via composer:

```bash
composer require maize-tech/laravel-access-logs
```

You can publish the config and migration files and run the migrations with:

```bash
php artisan access-logs:install
```

This is the contents of the published config file:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Access Log model
    |--------------------------------------------------------------------------
    |
    | Here you may specify the fully qualified class name of the access log
    | model.
    | By default, the value is Maize\AccessLogs\Models\AccessLog::class
    |
    */
    'model' => null,

    /*
    |--------------------------------------------------------------------------
    | Cache ttl
    |--------------------------------------------------------------------------
    |
    | Here you may specify cache time to live in seconds.
    | By default, the value is 3600
    |
    */
    'cache_ttl' => null,

    /*
    |--------------------------------------------------------------------------
    | Cache key
    |--------------------------------------------------------------------------
    |
    | Here you may specify the cache key.
    | You can define whether the settings should be cached or not,
    | the cache store, the key prefix and the default retention (in seconds).
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Get Cache Key Action
    |--------------------------------------------------------------------------
    |
    | Here you can specify the fully qualified class name of a custom action
    | used to get the cache key.
    | By default, the value is Maize\AccessLogs\Actions\GetCacheKeyAction::class
    */
    'cache_key_action' => null,
];
```

## Usage

To log users' access, the user model must implement the following interface and trait:

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Maize\AccessLogs\HasAccessLogs;
use Maize\AccessLogs\InteractWithAccessLogs;

class User extends Authenticatable implements HasAccessLogs
{
    use InteractWithAccessLogs;
}

```

Once done, you can add LogAccess middleware in your route group:
```php
Route::middleware(['auth:sanctum', LogAccess::class])->group(function () {
    // ...
});

```

TODO

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Enrico De Lazzari](https://github.com/enricodelazzari)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
