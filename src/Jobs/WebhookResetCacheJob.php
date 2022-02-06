<?php

namespace TripUp\Cache\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use TripUp\Cache\Contracts\RequestTagResolver;
use TripUp\Cache\Contracts\TagCache;

class WebhookResetCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    protected $tags;
    /** @var array|string|null */
    protected $data;
    /**
     * @param RequestTagResolver $requestTagResolver
     * @param TagCache $tagCache
     */
    public function __construct($tags = [], $data = null)
    {
        $this->tags = $tags;
        $this->data = $data;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TagCache $tagCache)
    {
        if (Arr::has($this->tags, "*")) {
            $tagCache->clearAll();
        } else {
            $tagCache->reset($this->tags);
        }
    }
}
