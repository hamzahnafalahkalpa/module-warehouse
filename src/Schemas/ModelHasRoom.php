<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\ModelHasRoom as ContractsModelHasRoom;
use Hanafalah\ModuleWarehouse\Contracts\Data\ModelHasRoomData;

class ModelHasRoom extends ModelHasWarehouse implements ContractsModelHasRoom
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
        $model_has_room = parent::prepareStoreModelHasWarehouse($model_has_room_dto);
        return static::$model_has_room_model = $model_has_room;
    }
}