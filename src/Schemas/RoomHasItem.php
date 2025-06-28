<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleWarehouse\{
    Supports\BaseModuleWarehouse
};
use Hanafalah\ModuleWarehouse\Contracts\Schemas\RoomHasItem as ContractsRoomHasItem;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomHasItemData;

class RoomHasItem extends BaseModuleWarehouse implements ContractsRoomHasItem
{
    protected string $__entity = 'RoomHasItem';
    public static $room_has_item_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'room_has_item',
            'tags'     => ['room_has_item', 'room_has_item-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreRoomHasItem(RoomHasItemData $room_has_item_dto): Model{
        $add = [
            'flag' => $room_has_item_dto->flag,
            'room_id' => $room_has_item_dto->room_id,
            'item_type' => $room_has_item_dto->item_type,
            'item_id' => $room_has_item_dto->item_id
        ];
        if (isset($room_has_item_dto->id)){
            $guard  = ['id' => $room_has_item_dto->id];
            $create = [$guard, $add];
        }else{
            $create = [$add];
        }

        $room_has_item = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($room_has_item,$room_has_item_dto->props);
        $room_has_item->save();
        return static::$room_has_item_model = $room_has_item;
    }
}