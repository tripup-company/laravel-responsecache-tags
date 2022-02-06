<?php

namespace TripUp\Cache\Resolvers\Strategies;

use TripUp\Cache\Dtos\PubSumEventDto;

interface RequestResolverStrategyContract
{
    /**
     * @param $content
     * @return bool
     */
    public function hasTags(PubSumEventDto $content): bool;

    /**
     * @param $content
     * @return array
     */
    public function getTags(PubSumEventDto $content): array;
}
