<?php

declare(strict_types=1);

namespace Swaty\CacheFallback;

use Illuminate\Cache\Repository;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Log;

class FallbackCacheRepository extends Repository
{
    protected Repository $fallback;

    public function __construct(Store $store, Store $fallback)
    {
        parent::__construct($store);
        $this->fallback = new Repository($fallback);
    }
    private function callWithFallback($method, $parameters)
    {
        try {
            return parent::{$method}(...$parameters);
            // return parent::__call($method, $parameters);
        } catch (\Exception $e) {
            Log::warning("Error call cache: {$e->getMessage()}, using fallback cache");

            return $this->fallback->{$method}(...$parameters);
        }
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null): mixed
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }

    /**
     * Retrieve multiple items from the cache by key.
     *
     * Items not found in the cache will have a null value.
     *
     * @param  array  $keys
     * @return array
     */
    public function many(array $keys)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }




    /**
     * Store an item in the cache.
     *
     * @param  array|string  $key
     * @param  mixed  $value
     * @param  \DateTimeInterface|\DateInterval|int|null  $ttl
     * @return bool
     */
    public function put($key, $value, $ttl = null)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }


    /**
     * Store multiple items in the cache for a given number of seconds.
     *
     * @param  array  $values
     * @param  \DateTimeInterface|\DateInterval|int|null  $ttl
     * @return bool
     */
    public function putMany(array $values, $ttl = null)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }


    /**
     * Store an item in the cache if the key does not exist.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  \DateTimeInterface|\DateInterval|int|null  $ttl
     * @return bool
     */
    public function add($key, $value, $ttl = null)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function increment($key, $value = 1)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function decrement($key, $value = 1)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return bool
     */
    public function forever($key, $value)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }


    /**
     * Retrieve an item from the cache by key, refreshing it in the background if it is stale.
     *
     * @template TCacheValue
     *
     * @param  string  $key
     * @param  array{ 0: \DateTimeInterface|\DateInterval|int, 1: \DateTimeInterface|\DateInterval|int }  $ttl
     * @param  (callable(): TCacheValue)  $callback
     * @param  array{ seconds?: int, owner?: string }|null  $lock
     * @return TCacheValue
     */
    public function flexible($key, $ttl, $callback, $lock = null)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function forget($key)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }


    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function clear(): bool
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }

    /**
     * Begin executing a new tags operation if the store supports it.
     *
     * @param  array|mixed  $names
     * @return \Illuminate\Cache\TaggedCache
     *
     * @throws \BadMethodCallException
     */
    public function tags($names)
    {
        return $this->callWithFallback(__FUNCTION__, func_get_args());
    }


    public function __call($method, $parameters)
    {
        try {
            // Попытка вызвать метод в основном драйвере
            return parent::__call($method, $parameters);
        } catch (\Exception $e) {
            Log::warning("Error call cache: {$e->getMessage()}, using fallback cache");

            // Переключаемся на резервное хранилище
            return $this->fallback->{$method}(...$parameters);
        }
    }
}
