<?php

declare(strict_types=1);

namespace Swaty\CacheFallback;

use Illuminate\Cache\CacheManager;
use Illuminate\Cache\CacheServiceProvider as ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application;

class CacheServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        parent::register();
        $this->app->singleton(CacheManager::class, function ($app) {
            return new FallbackCacheManager($app);
        });
        // Recreate the cache store with the fallback store
        $this->app->extend('cache', function ($service, Application $app) {
            return new FallbackCacheManager($app);
        });
    }
    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

}
