<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Room as ContractRoom;

class Room extends PackageManagement implements ContractRoom
{
    protected string $__entity = 'Room';
    public static $room_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'room',
            'tags'     => ['room', 'room-index'],
            'forever'  => true
        ],
        'show' => [
            'name'     => 'room',
            'tags'     => ['room', 'room-index'],
            'duration' => 60 * 12
        ]
    ];

    public function prepareStoreRoom(RoomData $room_dto): Model{
        $building = $this->schemaContract('building')->prepareStoreBuilding($room_dto->building);
        $room_dto->building_id ??= $building->getKey();
        $room     = $this->RoomModel()->updateOrCreate([
            'id'          => $room_dto->id ?? null,
        ], [
            'building_id' => $room_dto->building_id,
            'name'        => $room_dto->name
        ]);
        $this->fillingProps($room,$room_dto->props);
        $room->save();
        $this->forgetTags('room');
        return static::$room_model = $room;
    }

    public function storeRoom(? RoomData $room_dto = null): array{
        return $this->transaction(function() use ($room_dto) {
            return $this->showRoom($this->prepareStoreRoom($room_dto ?? $this->requestDTO(RoomData::class)));
        });
    }

    public function prepareDeleteRoom(?array $attributes = null): bool{
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('No id provided', 422);
        $room = $this->RoomModel()->findOrFail($attributes['id']);
        $room->modelHasRoom()->delete();
        return $room->delete();
    }

    public function room(mixed $conditionals = null): Builder{
        return $this->RoomModel()->conditionals($this->mergeCondition($conditionals ?? []))->withParameters()->orderBy('name','asc');
    }

}
