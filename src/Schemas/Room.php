<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\ModelHasRoomData;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomData;
use Hanafalah\ModuleWarehouse\Contracts\Data\WarehouseItemData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Room as ContractRoom;

class Room extends PackageManagement implements ContractRoom
{
    protected string $__entity = 'Room';
    public $room_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'room',
            'tags'     => ['room', 'room-index'],
            'forever'  => true
        ]
    ];

    public function createRoom(RoomData $room_dto): Model{
        return $this->usingEntity()->updateOrCreate([
            'id'          => $room_dto->id ?? null,
        ], [
            'building_id' => $room_dto->building_id,
            'name'        => $room_dto->name,
            'room_number' => $room_dto->room_number
        ]);
    }

    public function prepareStoreRoom(RoomData $room_dto): Model{
        if (isset($room_dto->building)){
            $building = $this->schemaContract('building')->prepareStoreBuilding($room_dto->building);
            $room_dto->building_id = $building->getKey();
            $room_dto->props['prop_building'] = [
                'id'   => $building->getKey(),
                'name' => $building->name
            ];
        }
        $room = $this->createRoom($room_dto);
        $room_dto->id = $room->getKey();

        $this->prepareStoreModelHasRooms($room_dto)
             ->prepareStoreWarehouseItems($room_dto);

        $this->fillingProps($room,$room_dto->props);
        $room->save();
        return $this->room_model = $room;
    }

    protected function prepareStoreModelHasRooms(RoomData &$room_dto): self{
        $model_has_room_ids = [];
        if (isset($room_dto->model_has_rooms) && count($room_dto->model_has_rooms) > 0){
            foreach ($room_dto->model_has_rooms as &$model_has_room) {
                $model_has_room->warehouse_type ??= 'Room';
                $model_has_room->warehouse_id = $room_dto->id;
                $model_has_room_model = $this->prepareStoreModelHasRoom($model_has_room);
                $model_has_room_ids[] = $model_has_room_model->id;
            }
        }
        $this->ModelHasRoomModel()->whereNotIn('id', $model_has_room_ids)
            ->where('warehouse_id',$room_dto->id)
            ->where('warehouse_type','Room')
            ->delete();
        return $this;
    }

    protected function prepareStoreWarehouseItems(RoomData &$room_dto): self{
        $warehouse_item_ids = [];
        if (isset($room_dto->warehouse_items) && count($room_dto->warehouse_items) > 0){
            foreach ($room_dto->warehouse_items as &$warehouse_item) {
                $warehouse_item->warehouse_type ??= 'Room';
                $warehouse_item->warehouse_id   = $room_dto->id;
                $warehouse_item_model = $this->prepareStoreWarehouseItem($warehouse_item);
                $warehouse_item_ids[] = $warehouse_item_model->getKey();
            }
        }
        $this->WarehouseItemModel()->whereNotIn('id', $warehouse_item_ids)
            ->where('warehouse_id',$room_dto->id)
            ->where('warehouse_type','Room')
            ->delete();
        return $this;
    }

    protected function prepareStoreModelHasRoom(ModelHasRoomData &$model_has_room): Model{
        return $this->schemaContract('model_has_room')
                    ->prepareStoreModelHasRoom($model_has_room);
    }

    protected function prepareStoreWarehouseItem(WarehouseItemData &$warehouse_item): Model{
        return $this->schemaContract('warehouse_item')
                    ->prepareStoreWarehouseItem($warehouse_item);
    }
}
