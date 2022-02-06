<?php

namespace TripUp\Cache\Resolvers\Strategies;

use TripUp\Cache\Dtos\PubSumEventDto;

interface ResponseResolverStrategyContract
{
    /**
     * @param $content
     * @return bool
     */
    public function hasTags($data): bool;

    /**
     * @param $content
     * @return array
     */
    public function getTags($data): array;
}
