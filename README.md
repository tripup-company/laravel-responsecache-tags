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
```

## Usage

You can inject TagCache instance in some service and reset part of response cache depending on some tag.
```php

```