<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\ModelHasRoomData as DataModelHasRoomData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ModelHasRoomData extends Data implements DataModelHasRoomData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('model_type')]
    #[MapName('model_type')]
    public string $model_type;

    #[MapInputName('model_id')]
    #[MapName('model_id')]
    public mixed $model_id;

    #[MapInputName('room_id')]
    #[MapName('room_id')]
    public mixed $room_id = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(self $data): self{
        $new = self::new();

        $props = &$data->props;

        $room = $new->RoomModel();
        $room = (isset($data->room_id)) ? $room->findOrFail($data->room_id) : $room;
        $props['prop_room'] = $room->toViewApi()->resolve();

        $model = $new->{$data->model_type.'Model'}();
        $model = (isset($data->model_id)) ? $model->findOrFail($data->model_id) : $model;
        $props['prop_model'] = $model->toViewApi()->resolve();
        return $data;
    }
}