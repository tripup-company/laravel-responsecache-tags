<?php
namespace TripUp\Cache\Dtos;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\DataTransferObject\DataTransferObject;

class PubSumEventDto extends DataTransferObject
{

    /**
     * @var string
     */
    public $action;
    /**
     * @var string
     */
    public $entity;
    /**
     * @var string
     */
    public $entityId;
    /**
     * @var array
     */
    public $payload;
    /**
     * @var string
     */
    public $publisher;
    public static function fromRequest(Request $request){
        self::validateRequest($request);
        $data = $request->all();
        return self::make($data);
    }

    public static function default(){
        return new self([
            "action"=>"",
            "entity"=>"",
            "entityId"=>"",
            "payload"=>[],
            "publisher"=>""
        ]);
    }

    /**
     * @param Request $request
     */
    protected static function validateRequest(Request $request): void
    {
        if (!$request->has("message")) {
            abort("400", "Wrong data format");
        }
        $data = $request->post('message');
        if (!Arr::has($data, "attributes") || !Arr::has($data, "data")) {
            abort("400", "Wrong data format");
        }
    }

    /**
     * @param array $data
     * @return static
     */
    public static function make(array $data): PubSumEventDto
    {
        return new static([
            "action" => Arr::get($data, "message.attributes.action", ""),
            "entity" => Arr::get($data, "message.attributes.entity", ""),
            "entityId" => Arr::get($data, "message.attributes.entityId", ""),
            "payload" => json_decode(Arr::get($data, "message.attributes.payload", "[]"), 1),
            "publisher" => base64_decode(Arr::get($data, "message.data")),
        ]);
    }

}
