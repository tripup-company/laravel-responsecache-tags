<?php
namespace Tests;

use Spatie\ResponseCache\ResponseCacheServiceProvider;
use TripUp\Cache\TagCacheServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    // protected $loadEnvironmentVariables = true;
    protected function getApplicationProviders($app)
    {
        return [
            \Illuminate\Auth\AuthServiceProvider::class,
            \Illuminate\Broadcasting\BroadcastServiceProvider::class,
            \Illuminate\Bus\BusServiceProvider::class,
            \Illuminate\Cache\CacheServiceProvider::class,
            \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
            \Illuminate\Cookie\CookieServiceProvider::class,
            \Illuminate\Database\DatabaseServiceProvider::class,
            \Illuminate\Encryption\EncryptionServiceProvider::class,
            \Illuminate\Filesystem\FilesystemServiceProvider::class,
            \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
            \Illuminate\Hashing\HashServiceProvider::class,
            \Illuminate\Mail\MailServiceProvider::class,
            \Illuminate\Notifications\NotificationServiceProvider::class,
            \Illuminate\Pagination\PaginationServiceProvider::class,
            \Illuminate\Pipeline\PipelineServiceProvider::class,
            \Illuminate\Queue\QueueServiceProvider::class,
            \Illuminate\Redis\RedisServiceProvider::class,
            \Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
            \Illuminate\Session\SessionServiceProvider::class,
            \Illuminate\Translation\TranslationServiceProvider::class,
            \Illuminate\Validation\ValidationServiceProvider::class,
            \Illuminate\View\ViewServiceProvider::class,
            TagCacheServiceProvider::class,
            ResponseCacheServiceProvider::class,
        ];
    }
}
