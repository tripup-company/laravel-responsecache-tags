<?php
namespace TripUp\Cache\Tags;

use TripUp\Cache\Contracts\Tag;

class ProductTag implements Tag
{
    protected $productId;

    /**
     * @param $productId
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }


    public function getTag(): string
    {
        return $this->productId;
    }
}
