<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\ModelHasRoom as ContractsModelHasRoom;
use Hanafalah\ModuleWarehouse\Contracts\Data\ModelHasRoomData;

class ModelHasRoom extends PackageManagement implements ContractsModelHasRoom
{
    protected string $__entity = 'ModelHasRoom';
    public static $model_has_room_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'model_has_room',
            'tags'     => ['model_has_room', 'model_has_room-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreModelHasRoom(ModelHasRoomData $model_has_room_dto): Model{
        $add = [
            'model_type' => $model_has_room_dto->model_type,
            'model_id' => $model_has_room_dto->model_id,
            'room_id' => $model_has_room_dto->room_id
        ];
        if (isset($model_has_room_dto->id)){
            $guard  = ['id' => $model_has_room_dto->id];
            $create = [$guard, $add];
        }else{
            $create = [$add]; 
        }
        $model_has_room = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($model_has_room,$model_has_room_dto->props);
        $model_has_room->save();
        return static::$model_has_room_model = $model_has_room;
    }
}