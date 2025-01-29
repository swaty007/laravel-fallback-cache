# Laravel Cache Fallback
![GitHub license](https://img.shields.io/github/license/swaty007/laravel-fallback-cache?style=flat-square)
![Packagist Version](https://img.shields.io/packagist/v/swaty/laravel-fallback-cache?style=flat-square)
![Packagist](https://img.shields.io/packagist/dt/swaty/laravel-fallback-cache?style=flat-square)
![GitHub issues](https://img.shields.io/github/issues/swaty007/laravel-fallback-cache?style=flat-square)
![GitHub pull requests](https://img.shields.io/github/issues-pr/swaty007/laravel-fallback-cache?style=flat-square)
![Codecov](https://img.shields.io/codecov/c/gh/swaty/laravel-fallback-cache?style=flat-square)
![Scrutinizer code quality](https://img.shields.io/scrutinizer/quality/g/swaty/laravel-fallback-cache?style=flat-square)

Allow Laravel cache connections to fallback to more stable drivers.

This package is especially useful when you want your application to be **fault-tolerant**.
For example, when using a Redis instance as cache store, you may want to be able to fallback to file store if the Redis instance is unavailable.

This package follows the [Semantic Versioning specification](https://semver.org).

## Prerequisites
- PHP >= 7.1.3
- Laravel/Lumen 9.x, 10.x, 11.x

## Supported cache methods
This package support most of the cache methods (e.g. get, put, etc.).
**The tagged cache is not supported at the moment.**


## Installation
Simply add `swaty/laravel-fallback-cache` to your package dependencies.

```bash
composer require swaty/laravel-fallback-cache
```

This package does not publish any resource and its configuration directly handled in the `config/cache.php` file.

### Laravel
This package uses [Laravel Package Discovery](https://laravel.com/docs/11.x/packages#package-discovery), so you do need to do anything more.
If you have disabled this feature, you can register the service provider in the `config/app.php`.

### Lumen
Register the service provider in the `bootstrap/app.php` file like so:

```php
$app->register(Swaty\CacheFallback\CacheServiceProvider::class);
```

## Usage
The `fallback` key at the top level (next to default) specifies a fallback driver that will be used for all stores unless a store explicitly defines its own fallback.

```php
<?php

return [
    'default' => env('CACHE_DRIVER', 'file'),
    'fallback'   => 'array',
    'stores'  => [
        'file'  => [
            'driver'   => 'file',
            'path'     => storage_path('framework/cache/data'),
        ],
        'redis' => [
            'driver'     => 'redis',
            'connection' => env('CACHE_REDIS_CONNECTION', 'cache'),
        ],
    ],
];
```
In the example above, if the `redis` store throws an exception, it will fallback to the `array` driver (as specified in its configuration).
For all other stores (e.g., file), if an exception occurs, they will fallback to the global `array` driver.