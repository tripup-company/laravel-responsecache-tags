<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use TripUp\Cache\Contracts\TagCache;


class TagRepositoryTest extends TestCase
{
    /**
     * @var TagCache
     */
    protected $repository;


    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(TagCache::class);
    }

    public function testPut()
    {
        $this->repository->put(["tag-1", "tag-2"], "response-cache-1");
        $this->repository->put(["tag-2", "tag-3"], "response-cache-2");

        $this->assertTrue(Cache::has('tag-1'));
        $this->assertTrue(Cache::has('tag-2'));
        $this->assertTrue(Cache::has('tag-3'));
    }

    public function testPutOne()
    {
        $this->repository->put("tag-1", "response-cache-1");
        $this->repository->put("tag-2", "response-cache-2");

        $this->assertTrue(Cache::has('tag-1'));
        $this->assertTrue(Cache::has('tag-2'));
        $this->assertTrue($this->repository->has('tag-1'));
        $this->assertTrue($this->repository->has('tag-1'));
    }

    public function testReset()
    {
        Cache::forever("response-cache-1", "response-cache-1-value");
        Cache::forever("response-cache-2", "response-cache-2-value");

        $this->repository->put(["tag-1", "tag-2"], "response-cache-1");
        $this->repository->put(["tag-2", "tag-3"], "response-cache-2");

        $this->repository->reset("tag-1");

        $this->assertFalse(Cache::has('tag-1'));
        $this->assertTrue(Cache::has('tag-2'));
        $this->assertTrue(Cache::has('tag-3'));
        $this->assertFalse(Cache::has('response-cache-1'));
        $this->assertTrue(Cache::has('response-cache-2'));
    }

    public function testResetRelated()
    {
        Cache::forever("response-cache-1", "response-cache-1-value");
        Cache::forever("response-cache-2", "response-cache-2-value");

        $this->repository->put(["tag-1", "tag-2"], "response-cache-1");
        $this->repository->put(["tag-2", "tag-3"], "response-cache-2");

        $this->repository->reset("tag-2");

        $this->assertTrue(Cache::has('tag-1'));
        $this->assertFalse(Cache::has('tag-2'));
        $this->assertTrue(Cache::has('tag-3'));
        $this->assertFalse(Cache::has('response-cache-1'));
        $this->assertFalse(Cache::has('response-cache-2'));
    }

    public function testResetOneTag()
    {
        Cache::forever("response-cache-1", "response-cache-1-value");
        $this->repository->put("tag-1", "response-cache-1");

        $this->assertTrue(Cache::has('tag-1'));
        $this->assertTrue($this->repository->has("tag-1"));
        $this->assertTrue(Cache::has('response-cache-1'));

        $this->repository->reset("tag-1");

        $this->assertFalse(Cache::has('tag-1'));
        $this->assertFalse($this->repository->has("tag-1"));
        $this->assertFalse(Cache::has('response-cache-1'));

    }

    public function testResetAll()
    {
        Cache::forever("response-cache-1", "response-cache-1-value");
        Cache::forever("response-cache-2", "response-cache-2-value");

        $this->repository->put(["tag-1", "tag-2"], "response-cache-1");
        $this->repository->put(["tag-2", "tag-3"], "response-cache-2");
        $this->repository->clearAll();

        $this->assertFalse(Cache::has('tag-1'));
        $this->assertFalse(Cache::has('tag-2'));
        $this->assertFalse(Cache::has('tag-3'));
        $this->assertFalse(Cache::has('response-cache-1'));
        $this->assertFalse(Cache::has('response-cache-2'));
    }
}
