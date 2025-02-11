<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;

it('test Get', function () {
    // We use the fallback array cache store
    Cache::store()->set('foo', 'bar', 10);

    $this->assertEquals('bar', Cache::store()->get('foo'));
});

it('test Many', function () {
    $data = ['a' => 'foo', 'b' => 'bar'];

    Cache::store()->putMany($data, 10);
    $this->assertEquals($data, Cache::store()->many(array_keys($data)));
});

it('test Put', function () {
    $this->assertTrue(Cache::store()->put('foo', 'bar', 10));
    $this->assertEquals('bar', Cache::store()->get('foo'));
});

it('test PutMany', function () {
    $this->assertTrue(Cache::store()->putMany([
        'a' => 'foo',
        'b' => 'bar',
    ], 10));
    $this->assertEquals('foo', Cache::store()->get('a'));
    $this->assertEquals('bar', Cache::store()->get('b'));
});

it('test Add', function () {
    $this->assertTrue(Cache::store()->add('foo', 'bar', 10));
    $this->assertEquals('bar', Cache::store()->get('foo'));
});
it('test Increment', function () {
    $this->assertTrue(Cache::store()->set('counter', 10, 10));
    $this->assertEquals(11, Cache::store()->increment('counter'));
});

it('test Decrement', function () {
    $this->assertTrue(Cache::store()->set('counter', 10, 10));
    $this->assertEquals(9, Cache::store()->decrement('counter'));
});

it('test Forever', function () {
    $this->assertTrue(Cache::store()->forever('foo', 'bar'));
    $this->assertEquals('bar', Cache::store()->get('foo'));
});

it('test Forget', function () {
    Cache::store()->set('foo', 'bar', 10);

    $this->assertEquals('bar', Cache::store()->get('foo'));
    $this->assertTrue(Cache::store()->forget('foo'));
    $this->assertNull(Cache::store()->get('foo'));
});

it('test Clear', function () {
    Cache::store()->set('foo', 'bar', 10);

    $this->assertEquals('bar', Cache::store()->get('foo'));
    $this->assertTrue(Cache::store()->clear());
    $this->assertNull(Cache::store()->get('foo'));
});
