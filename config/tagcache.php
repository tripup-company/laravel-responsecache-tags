<?php
return [
    /*
    * Determine if the response cache middleware should be enabled.
    */
    "enabled" => env("RESPONSE_CACHE_TAG_ENAVLE", true),

    /*
     *  The given class will determinate if a request has tags.
     *  The default class resolve tags from json response collection with objects field id.
     *
     *  You can provide your own class given that it implements the
     *  ResponseTagResolver interface.
     */
    "tag_resolver" => \TripUp\Cache\Resolvers\DefaultResponseTagResolver::class,

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
