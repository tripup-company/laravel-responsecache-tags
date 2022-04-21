<?php

namespace Tests\Unit\Resolvers\Requests;

use Tests\LoadPubSubRequestTrait;
use Tests\TestCase;
use TripUp\Cache\Dtos\PubSumEventDto;
use TripUp\Cache\Resolvers\Requests\ClearAllRequestStrategy;
use TripUp\Cache\Resolvers\Strategies\RequestResolverStrategyContract;

class ClearAllRequestStrategyTest extends TestCase
{
    use LoadPubSubRequestTrait;

    protected RequestResolverStrategyContract $resolver;

    public function testHasTags()
    {
        $data = $this->getRequestData("clear_all");
        $res = $this->resolver->hasTags(PubSumEventDto::make($data));
        $this->assertTrue($res);
    }

    public function testGetTags()
    {
        $data = $this->getRequestData("clear_all");
        $res = $this->resolver->getTags(PubSumEventDto::make($data));
        $this->assertCount(1, $res);
        $this->assertTrue(in_array("*", $res));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = $this->app->make(ClearAllRequestStrategy::class);
    }

}