<?php

namespace TripUp\Cache\Repositories;

use Illuminate\Support\Facades\Cache;
use TripUp\Cache\Contracts\Serializer;

class TagCacheRepository implements \TripUp\Cache\Contracts\TagCache
{
    protected $tagsKey = "response_tag_key";
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
        $this->tagsKey = config("tagcache.tags_cache_key") ?? $this->tagsKey;
    }

    /**
     * @param string|string[] $tags
     * @param string $responseCacheKey
     * @return bool
     * @throws \Exception
     */
    public function put($tags, string $responseCacheKey): bool
    {
        $tags = $this->preprocessTags($tags);
        foreach ($tags as $tag) {
            $responsesKeyPool = [];
            $this->storeTags($tag);
            if (Cache::has($tag)) {
                $responsesKeyPool = $this->serializer->deserialize(Cache::get($tag));
            }
            if (in_array($responseCacheKey, $responsesKeyPool)) {
                continue;
            }
            $responsesKeyPool[] = $responseCacheKey;
            Cache::forever($tag, $this->serializer->serialize($responsesKeyPool));
        }
        return true;
    }

    /**
     * @param string|string[] $tags
     * @return bool
     * @throws \Exception
     */
    public function reset($tags): bool
    {
        $tags = $this->preprocessTags($tags);
        foreach ($tags as $tag) {
            if (Cache::has($tag)) {
                $this->forgetResponseCaches($this->serializer->deserialize(Cache::get($tag)));
            }
            Cache::forget($tag);
        }
        $this->removeTags($tags);
        return true;
    }

    public function clearAll(): bool
    {
        $storedTags = $this->serializer->deserialize(Cache::get($this->tagsKey));
        return $this->reset($storedTags);
    }

    /**
     * @param $tags
     * @return array|mixed
     * @throws \Exception
     */
    protected function preprocessTags($tags)
    {
        if (!is_array($tags)) {
            $tags = [$tags];
        }
        foreach ($tags as $tag) {
            if (!is_string($tag)) {
                throw new \Exception("Wrong tag format. Tag must be string!");
            }
        }
        return $tags;
    }

    /**
     * @param string $tag
     */
    protected function storeTags($tags)
    {
        $tags = $this->preprocessTags($tags);
        $storedTags = [];
        if (Cache::has($this->tagsKey)) {
            $storedTags = $this->serializer->deserialize(Cache::get($this->tagsKey));
        }
        Cache::forever($this->tagsKey, $this->serializer->serialize(array_unique(array_merge($storedTags, $tags))));
    }

    /**
     * @param $tags
     * @throws \Exception
     */
    protected function removeTags($tags)
    {
        $tags = $this->preprocessTags($tags);
        $storedTags = [];
        if (Cache::has($this->tagsKey)) {
            $storedTags = $this->serializer->deserialize(Cache::get($this->tagsKey));
        }
        $storedTags = array_diff($storedTags, $tags);
        Cache::forever($this->tagsKey, $this->serializer->serialize($storedTags));
    }

    /**
     * @param $keys
     */
    protected function forgetResponseCaches($keys)
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function has(string $tag): bool
    {
        $storedTags = $this->serializer->deserialize(Cache::get($this->tagsKey));
        return in_array($tag, $storedTags);
    }

}
