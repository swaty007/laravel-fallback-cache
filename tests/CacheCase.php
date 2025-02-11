<?php

namespace Swaty\CacheFallback\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class CacheCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.redis', [
            'redis' => [
                'client' => 'predis',
                'cache' => [
                    'host' => '127.0.0.1',
                    'port' => '6666', // invalid port
                ],
            ],
        ]);
        config()->set('cache.stores', array_merge(config()->get('cache.stores'), [
            'bad_driver' => [
                'driver' => 'redis',
                'connection' => 'cache',
            ],
        ]));
        config()->set('cache.default', 'bad_driver');
        config()->set('cache.fallback', 'array');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
