<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\BuildingData;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomData as DataRoomData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class RoomData extends Data implements DataRoomData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('room_number')]
    #[MapName('room_number')]
    public ?string $room_number = null;

    #[MapInputName('building_id')]
    #[MapName('building_id')]
    public mixed $building_id = null;

    #[MapInputName('building')]
    #[MapName('building')]
    public ?BuildingData $building = null;

    #[MapInputName('model_has_rooms')]
    #[MapName('model_has_rooms')]
    #[DataCollectionOf(ModelHasRoomData::class)]
    public ?array $model_has_rooms = null;

    #[MapInputName('model_has_warehouses')]
    #[MapName('model_has_warehouses')]
    #[DataCollectionOf(ModelHasWarehouseData::class)]
    public ?array $model_has_warehouses = null;

    #[MapInputName('warehouse_items')]
    #[MapName('warehouse_items')]
    #[DataCollectionOf(WarehouseItemData::class)]
    public ?array $warehouse_items = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public mixed $props = null;

    public static function after(RoomData $data): RoomData{
        $data->props['prop_building'] = [
            'id'   => $data->building_id ?? null,
            'name' => null
        ];
        $new = self::new();
        if (isset($data->building_id)){
            $building = $new->BuildingModel()->findOrFail($data->building_id);
            $data->props['prop_building']['name'] = $building->name;
        }
        return $data;
    }
}