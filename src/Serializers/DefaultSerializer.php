<?php

namespace TripUp\Cache\Serializers;

use TripUp\Cache\Contracts\Serializer;

class DefaultSerializer implements Serializer
{

    public function serialize($data): string
    {
        return json_encode($data);
    }

    public function deserialize(string $data)
    {
        return json_decode($data,1);
    }
}
