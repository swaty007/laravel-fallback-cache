<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;
use Swaty\CacheFallback\FallbackCacheRepository;

it('test register', function () {
    $store = Cache::store();
    $this->assertInstanceOf(FallbackCacheRepository::class, $store);
});
