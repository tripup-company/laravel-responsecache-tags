<?php

namespace TripUp\Cache\Resolvers\Strategies;

abstract class AbstractResponseResolveStrategy implements ResponseResolverStrategyContract
{
    public function hasTags($content): bool
    {
        return $this->hasData($content)
            && $this->validCollection($content["data"])
            && $this->validItem(array_shift($content["data"]));
    }

    /**
     * @param $content
     * @return bool
     */
    protected function hasData($content): bool
    {
        return is_array($content) && isset($content["data"]);
    }

    /**
     * @param $content
     * @return bool
     */
    protected function validCollection($content): bool
    {
        return is_array($content) && array_is_list($content);
    }

    /**
     * @param $item
     * @return bool
     */
    abstract protected function validItem($item): bool;

    /**
     * @param $content
     * @return array
     */
    abstract function getTags($content): array;
}
