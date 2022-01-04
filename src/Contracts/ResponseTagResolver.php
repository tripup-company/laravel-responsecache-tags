<?php

namespace TripUp\Cache\Contracts;

use Illuminate\Http\Response;

interface ResponseTagResolver
{
    /**
     * @param Response $response
     * @return array
     */
    public function resolveTags(Response $response):array;
}
