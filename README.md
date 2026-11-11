# Laravel Access Logs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maize-tech/laravel-access-logs.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-access-logs)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/maize-tech/laravel-access-logs/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/maize-tech/laravel-access-logs/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/maize-tech/laravel-access-logs/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/maize-tech/laravel-access-logs/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/maize-tech/laravel-access-logs.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-access-logs)

Easily log daily user access to your application.

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
    | Get Cache Key Action
    |--------------------------------------------------------------------------
    |
    | Here you can specify the fully qualified class name of a custom action
    | used to get the cache key.
    | By default, the value is Maize\AccessLogs\Actions\GetCacheKeyAction::class
    |
    */
    'cache_key_action' => null,
];
```

## Usage

### Basic

To log users' access, your authenticatable model must implement the `HasAccessLogs` interface and use the `InteractsWithAccessLogs` trait:

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Maize\AccessLogs\HasAccessLogs;
use Maize\AccessLogs\InteractsWithAccessLogs;

class User extends Authenticatable implements HasAccessLogs
{
    use InteractsWithAccessLogs;
}
```

Once done, add the `LogAccess` middleware to the routes you want to track:

```php
use Maize\AccessLogs\Http\Middleware\LogAccess;

Route::middleware(['auth', LogAccess::class])->group(function () {
    // ...
});
```

That's it! The middleware will store at most one access log per user per day.
Requests made by guests, or by users whose model does not implement `HasAccessLogs`, are ignored.

To avoid querying the database on every request, the last access of each user is cached (see the `cache_ttl` option).

### Retrieving access logs

The `InteractsWithAccessLogs` trait adds an `accessLogs` relationship to your model:

```php
$user->accessLogs()->count(); // number of days the user accessed the application

$user->accessLogs()
    ->where('accessed_at', '>=', now()->subMonth())
    ->get();
```

You can also retrieve the last access of a given user:

```php
use Maize\AccessLogs\Models\AccessLog;

AccessLog::lastAccess($user)?->accessed_at;
```

If you need to register an access manually (e.g. outside of an HTTP request), you can use the `registerAccess` method.
It will only create a new record if the user has not accessed the application yet today:

```php
AccessLog::registerAccess($user);
```

When a model using the `InteractsWithAccessLogs` trait is deleted, all its access logs are deleted as well.

### Listening to new accesses

Every time a new access log is created, the `Maize\AccessLogs\Events\NewAccess` event is dispatched.
You can listen to it to perform any custom action, like updating a `last_login_at` column or sending a notification:

```php
use Illuminate\Support\Facades\Event;
use Maize\AccessLogs\Events\NewAccess;

Event::listen(function (NewAccess $event) {
    $user = $event->accessLog->user;

    // ...
});
```

### Custom model

If you need to customize the access log model, you can extend the default one and set its fully qualified class name in the `model` option of the config file:

```php
use Maize\AccessLogs\Models\AccessLog as BaseAccessLog;

class AccessLog extends BaseAccessLog
{
    // ...
}
```

```php
'model' => \App\Models\AccessLog::class,
```

### Cache

By default, the last access of each user is cached for one hour. You can change the duration (in seconds) using the `cache_ttl` option:

```php
'cache_ttl' => 600, // 10 minutes
```

You can also customize how the cache key is generated by extending the `GetCacheKeyAction` class and setting it in the `cache_key_action` option:

```php
use Illuminate\Database\Eloquent\Model;
use Maize\AccessLogs\Actions\GetCacheKeyAction as BaseGetCacheKeyAction;
use Maize\AccessLogs\HasAccessLogs;

class GetCacheKeyAction extends BaseGetCacheKeyAction
{
    public function __invoke(Model&HasAccessLogs $model): string
    {
        return "my-app.access-logs.{$model->getMorphClass()}.{$model->getKey()}";
    }
}
```

```php
'cache_key_action' => \App\Actions\GetCacheKeyAction::class,
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/maize-tech/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](https://github.com/maize-tech/.github/security/policy) on how to report security vulnerabilities.

## Credits

- [Enrico De Lazzari](https://github.com/enricodelazzari)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
