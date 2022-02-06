<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use TripUp\Cache\Jobs\WebhookResetCacheJob;

class WebhookResetCacheJobCalledTest extends TestCase
{
    public function testJobIsCalled()
    {
        Bus::fake();
        $response = $this->postJson(route("reset-cache.webhook", ["key" => config("tagcache.webhook_secret")]),
            [
                "message" => [
                    "attributes" => [
                        "action" => "saved",
                        "entity" => "App\\Models\\Event",
                        "entityId" => "9889",
                        "payload" => "{\"group_shop_product_id\":\"DBV-003-00-DE\"}"
                    ],
                    "data" => "SW52ZW50b3J5IE1nbXQ=",
                ],
            ]
        );
        $response->isOk();
        Bus::assertDispatched(WebhookResetCacheJob::class);
    }

}
