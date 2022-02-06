<?php

namespace TripUp\Cache\Resolvers;

use Illuminate\Http\Request;
use TripUp\Cache\Contracts;

class DefaultRequestTagResolver implements RequestTagResolver
{
    public function resolveTags(Request $response): array
    {
        return [];
    }

}
