<?php
namespace TripUp\Cache;

use Illuminate\Cache\Events\KeyWritten;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TripUp\Cache\Contracts\RequestTagResolver;
use TripUp\Cache\Contracts\ResponseTagResolver;
use TripUp\Cache\Contracts\Serializer;
use TripUp\Cache\Contracts\TagCache;
use TripUp\Cache\Controllers\WebhookController;
use TripUp\Cache\Listeners\CacheWriteListener;
use TripUp\Cache\Middlewares\WebhookAccess;
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
        Route::aliasMiddleware("webhook-access", WebhookAccess::class);
        Route::post(config("tagcache.webhook"),[WebhookController::class,'resetCache'])
            ->middleware(["webhook-access"])
            ->name('reset-cache.webhook');

    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('tagcache')
            ->hasConfigFile();
    }
}
