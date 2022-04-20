<?php

namespace Tests;

trait LoadPubSubRequestTrait
{
    /**
     * @param $type
     * @return mixed
     */
    protected function getRequestData($type)
    {
        return \json_decode(file_get_contents(realpath("../../../_data/resolvers/requests/{$type}.json")), 1);
    }
}