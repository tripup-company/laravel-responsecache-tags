<?php

namespace TripUp\Cache\Resolvers;

use Illuminate\Http\Response;

class DefaultResponseTagResolver implements ResponseTagResolver
{
    /**
     * @param Response $response
     * @return array
     */
    public function resolveTags(Response $response): array
    {
        $data = collect(json_decode($response->getContent())->data);
        return $data->map(function ($item) {
            return new $item->id;
        })->toArray();
    }
}
