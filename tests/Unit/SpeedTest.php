<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use TripUp\Cache\Contracts\TagCache;

class SpeedTest extends TestCase
{
    /**
     * @var TagCache
     */
    protected $repository;

    public function testSpeed()
    {
        Config::set("cache.default", "memcached");
        Config::set("cache.stores.memcached.servers", [["host" => "memcached","port"=>11211,"weight" => 100]]);
        print_r(config("cache.default"));
        $tagsCount = 1;
        $rcCount = 2000;
        $start = microtime(true);
        for ($j = 0; $j < $rcCount; $j++) {
            $rcKey = "cache-key-$j";
            Cache::forever($rcKey, "cache-value-$j");
        }
        $time_elapsed_secs = microtime(true) - $start;
        print("\n".$rcCount . " cache sets: " . $time_elapsed_secs);
        $oneCacheSet = $time_elapsed_secs / $rcCount;
        print("\nOne cache sets: " . $oneCacheSet);

        for ($j = 0; $j < $tagsCount; $j++) {
            for ($k = 0; $k < $rcCount ; $k++) {
                $this->repository->put("tag-$j", "cache-key-" . $k);
            }
        }
        $this->repository->debug();
        $start = microtime(true);
        $this->repository->reset("tag-" . random_int(0, $rcCount - 1));
        $time_elapsed_secs = microtime(true) - $start;
        print("\nOne tag reset time: " . $time_elapsed_secs);
        print("\nSet and reset tag cache relations: 1 to " . $time_elapsed_secs/ $oneCacheSet);
        $this->assertTrue(true);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(TagCache::class);
    }

}
