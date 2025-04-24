<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\BuildingData;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomData as DataRoomData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class RoomData extends Data implements DataRoomData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('building_id')]
    #[MapName('building_id')]
    public mixed $building_id = null;

    #[MapInputName('building')]
    #[MapName('building')]
    public ?BuildingData $building = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public mixed $props = null;
}