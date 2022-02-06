<?php

namespace TripUp\Cache\Resolvers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TripUp\Cache\Contracts\RequestTagResolver;
use TripUp\Cache\Dtos\PubSumEventDto;
use TripUp\Cache\Resolvers\Strategies\RequestResolverStrategyContract;


class DefaultRequestTagResolver implements RequestTagResolver
{
    /**
     * @var RequestResolverStrategyContract[]
     */
    protected $resolverClasses = [];

    public function __construct()
    {
        $this->resolverClasses = config("tagcache.tag_request_resolver_strategies", []);
    }

    public function resolveTags(Request $request): array
    {
        $tags = [];
        try {
            $data = PubSumEventDto::fromRequest($request);
            foreach ($this->resolverClasses as $resolverClass) {
                $resolverInstance = app()->make($resolverClass);
                abort_unless($resolverInstance instanceof RequestResolverStrategyContract,
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

}
