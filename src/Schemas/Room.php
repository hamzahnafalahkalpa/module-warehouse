<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Room as ContractRoom;

class Room extends PackageManagement implements ContractRoom
{
    protected string $__entity = 'Room';
    public static $room_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'room',
            'tags'     => ['room', 'room-index'],
            'forever'  => true
        ]
    ];

    public function prepareStoreRoom(RoomData $room_dto): Model{
        if (isset($room_dto->building)){
            $building = $this->schemaContract('building')->prepareStoreBuilding($room_dto->building);
            $room_dto->building_id = $building->getKey();
            $room_dto->props['prop_building'] = [
                'id'   => $building->getKey(),
                'name' => $building->name
            ];
        }
        $room = $this->RoomModel()->updateOrCreate([
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
}
