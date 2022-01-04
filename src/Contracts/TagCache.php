<?php

namespace TripUp\Cache\Contracts;

interface TagCache
{
    /**
     * @param string|string[] $tags
     * @param string $responseCacheKey
     * @return bool
     */
    public function put($tags, string $responseCacheKey): bool;

    /**
     * @param string|string[] $tags
     * @return bool
     */
    public function reset($tags): bool;

    /**
     * @return bool
     */
    public function clearAll(): bool;

    /**
     * @param string $tag
     * @return bool
     */
    public function has(string $tag): bool;
}
