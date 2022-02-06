<?php
return [
    /*
    * Determine if the response cache middleware should be enabled.
    */
    "enabled" => env("RESPONSE_CACHE_TAG_ENABLE", true),
    "webhook" => env("RESPONSE_CACHE_WEBHOOK", "/inventory/reset-cache"),
    "webhook_secret" => env("RESPONSE_CACHE_WEBHOOK_SECRET", "secret"),
    "webhook_jobs" => [
        \TripUp\Cache\Jobs\WebhookResetCacheJob::class,
    ],
    /*
     *  The given class will determinate if a request has tags.
     *  The default class resolve tags from json response collection with objects field id.
     *
     *  You can provide your own class given that it implements the
     *  ResponseTagResolver interface.
     */
    "tag_response_resolver" => \TripUp\Cache\Resolvers\DefaultResponseTagResolver::class,
    "tag_response_resolver_strategies" => [
        //... Here must be the RequestResolverStrategyContract implementations
    ],
    "tag_request_resolver" => \TripUp\Cache\Resolvers\DefaultRequestTagResolver::class,
    "tag_request_resolver_strategies" => [
        // ... Here must be the ResponseResolverStrategyContract implementations
    ],

    /*
    *  The given class implement TagCache interface if a request has tags.
    *  The default class use default laravel cache driver.
    *
    *  You can provide your own class given that it implements the
    *  TagCache interface.
    */
    "tag_store" => \TripUp\Cache\Repositories\TagCacheRepository::class,

    /*
     * This key uses to store the available tags
     * You should use an uniq cache key string here.
     */
    "tags_cache_key" => env("RESPONSE_CACHE_TAG_KEY", "tags-cache-key"),
];
