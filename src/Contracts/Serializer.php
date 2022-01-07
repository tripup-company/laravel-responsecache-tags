<?php

namespace TripUp\Cache\Contracts;

interface Serializer
{
    /**
     * @param $data
     * @return string
     */
    public function serialize($data): string;

    /**
     * @param string $data
     * @return mixed
     */
    public function deserialize(string $data);
}
