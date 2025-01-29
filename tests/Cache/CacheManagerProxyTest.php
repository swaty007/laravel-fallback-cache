<?php

declare(strict_types=1);

it('test get store name', function () {
    $manager = $this->app->make('cache');
    $this->assertEquals(\Swaty\CacheFallback\FallbackCacheManager::class, $manager::class);
});
