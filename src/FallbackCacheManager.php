<?php

declare(strict_types=1);

namespace Swaty\CacheFallback;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

class FallbackCacheManager extends CacheManager
{
    public function store($name = null)
    {
        $repository = new FallbackCacheRepository(parent::store($name)->getStore(), parent::store(config('cache.fallback', 'array'))->getStore());
        if ($this->app->bound(DispatcherContract::class)) {
            $repository->setEventDispatcher($this->app[DispatcherContract::class]);
        }

        return $repository;
    }
}
