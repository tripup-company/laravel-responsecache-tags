<?php
namespace TripUp\Cache\Listeners;

use Illuminate\Cache\Events\KeyWritten;
use Spatie\ResponseCache\Serializers\Serializer;
use TripUp\Cache\Contracts\ResponseTagResolver;
use TripUp\Cache\Contracts\TagCache;
use TripUp\Cache\Tags\ProductsCollectionTags;

class CacheWriteListener
{
    /**
     * @var Serializer
     */
    protected $serializer;
    /**
     * @var ResponseTagResolver
     */
    protected $resolver;
    /**
     * @var TagCache
     */
    protected $tagCache;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Serializer $serializer, ResponseTagResolver $resolver, TagCache $tagCache)
    {
        $this->serializer = $serializer;
        $this->resolver = $resolver;
        $this->tagCache = $tagCache;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(KeyWritten $event)
    {
        if (!$this->isResponseCacheEvent($event) || !config("tagcache.enabled")) {
            return;
        }
        $response = $this->serializer->unserialize($event->value);
        $tags = $this->resolver->resolveTags($response);
        $this->tagCache->put($tags, $event->key);
    }

    /**
     * @param KeyWritten $event
     * @return bool
     */
    public function isResponseCacheEvent(KeyWritten $event)
    {
        return strpos($event->key, "responsecache") !== false;
    }
}
