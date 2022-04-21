<?php

namespace TripUp\Cache\Resolvers\Requests;

use TripUp\Cache\Dtos\PubSumEventDto;
use TripUp\Cache\Resolvers\Strategies\RequestResolverStrategyContract;

class ClearAllRequestStrategy implements RequestResolverStrategyContract
{

    public function hasTags(PubSumEventDto $content): bool
    {
        return $content->action == "clear" && $content->entity = "any";
    }

    public function getTags(PubSumEventDto $content): array
    {
        return ["*"];
    }
}