# Tagable laravel response cache
This Laravel package use [Laravel response cache](https://spatie.be/videos/laravel-package-training/laravel-responsecache) 
package to cache an entire response and realize the ability to invalidate only part of cache
depending on tags from response.


## Installation

You can install the package via composer:
```bash
composer require tripup-company/laravel-responsecache-tags
```

The package will automatically register itself.

Next, you should configure [Laravel response cache](https://spatie.be/videos/laravel-package-training/laravel-responsecache) package.

You can publish the config file with:
```bash
php artisan vendor:publish --provider="TripUp\Cache\TagCacheServiceProvider"
```

This is the contents of the published config file:

```php
// config/tagcache.php
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


```
## Default request resolver

```php
<?php

namespace TripUp\Cache\Resolvers;

use Illuminate\Http\Request;
use TripUp\Cache\Contracts\RequestTagResolver;
use TripUp\Cache\Dtos\PubSumEventDto;


class DefaultRequestTagResolver implements RequestTagResolver
{
    public function resolveTags(Request $request): array
    {
        $data = PubSumEventDto::fromRequest($request);
        if ($data->entity === "App\Models\Product" && isset($data->payload["group_shop_product_id"])){
            $tags[] = "product:".$data->payload["group_shop_product_id"];
        }
        return $tags;
    }

}

```
## Default response resolver
```php
<?php

namespace TripUp\Cache\Resolvers;

use Illuminate\Http\Response;
use TripUp\Cache\Contracts\ResponseTagResolver;

class DefaultResponseTagResolver implements ResponseTagResolver
{
    /**
     * @param Response $response
     * @return array
     */
    public function resolveTags(Response $response): array
    {
        $data = collect(json_decode($response->getContent())->data);
        return $data->map(function ($item) {
            return "product:".$item->id;
        })->toArray();
    }
}
```
## Reserved tag

There are reserved tag names:

 | Tag | Description | 
| --- | --- |
| * | If this tag exist webhook will call **clearAll()** method |


## Usage

You can inject TagCache instance in some service and reset part of response cache depending on some tag.
```php

```
