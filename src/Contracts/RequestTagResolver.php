<?php

namespace TripUp\Cache\Contracts;

use Illuminate\Http\Request;

interface RequestTagResolver
{
    /**
     * @param Request $response
     * @return array
     */
    public function resolveTags(Request $response): array;
}
