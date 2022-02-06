<?php
namespace TripUp\Cache;

use Illuminate\Cache\Events\KeyWritten;
use Illuminate\Container\Container;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TripUp\Cache\Contracts\ResponseTagResolver;
use TripUp\Cache\Contracts\Serializer;
use TripUp\Cache\Contracts\TagCache;
use TripUp\Cache\Listeners\CacheWriteListener;
use TripUp\Cache\Serializers\DefaultSerializer;

class TagCacheServiceProvider extends PackageServiceProvider
{
    public function packageBooted()
    {
        \Event::listen(KeyWritten::class, CacheWriteListener::class);

        $this->app->singleton(ResponseTagResolver::class, function (Container $app) {
            return $app->make(config('tagcache.tag_response_resolver'));
        });
        $this->app->singleton(RequestTagResolver::class, function (Container $app) {
            return $app->make(config('tagcache.tag_request_resolver'));
        });
        $this->app->singleton(TagCache::class, function (Container $app) {
            return $app->make(config('tagcache.tag_store'));
        });

        $this->app->bind(Serializer::class, DefaultSerializer::class);

    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('tagcache')
            ->hasConfigFile();
    }
}
