<?php

declare(strict_types=1);

namespace Swaty\CacheFallback;

use Illuminate\Cache\CacheManager;

class FallbackCacheManager extends CacheManager
{
    public function store($name = null)
    {
        return new FallbackCacheRepository(parent::store($name)->getStore(), parent::store(config('cache.fallback', 'array'))->getStore());
    }
}
