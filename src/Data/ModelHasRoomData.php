<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\ModuleWarehouse\Contracts\Data\ModelHasRoomData as DataModelHasRoomData;

class ModelHasRoomData extends ModelHasWarehouseData implements DataModelHasRoomData
{
    public static function before(array &$attributes){
        $attributes['warehouse_type'] ??= 'Room';
    }

    public static function after(mixed $data): self{
        $new = self::new();
        $props = &$data->props;
        $room = $new->RoomModel();
        $room = (isset($data->warehouse_id)) ? $room->findOrFail($data->warehouse_id) : $room;
        $props['prop_room'] = $room->toViewApi()->resolve();

        parent::after($data);
        return $data;
    }
}