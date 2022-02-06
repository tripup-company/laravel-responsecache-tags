<?php

namespace TripUp\Cache\Resolvers;

use Illuminate\Http\Response;
use TripUp\Cache\Contracts\ResponseTagResolver;
use TripUp\Cache\Resolvers\Strategies\ResponseResolverStrategyContract;

class DefaultResponseTagResolver implements ResponseTagResolver
{
    /**
     * @var ResponseResolverStrategyContract[]
     */
    protected $resolverClasses = [];

    public function __construct()
    {
        $this->resolverClasses = config("tagcache.tag_response_resolver_strategies", []);
    }

    public function resolveTags(Response $response): array
    {
        $tags = [];
        try {
            $data = $this->getDataFromResponse($response);
            foreach ($this->resolverClasses as $resolverClass) {
                $resolverInstance = app()->make($resolverClass);
                abort_unless($resolverInstance instanceof ResponseResolverStrategyContract,
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    "Wrong tag resolver instance");
                if ($resolverInstance->hasTags($data)) {
                    $tags = $tags + $resolverInstance->getTags($data);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return $tags;
    }

    /**
     * @param Response $response
     * @return mixed
     */
    protected function getDataFromResponse(Response $response)
    {
        return \json_decode($response->getContent(), 1);
    }


}
