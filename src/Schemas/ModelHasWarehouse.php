<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleWarehouse\{
    Supports\BaseModuleWarehouse
};
use Hanafalah\ModuleWarehouse\Contracts\Schemas\ModelHasWarehouse as ContractsModelHasWarehouse;
use Hanafalah\ModuleWarehouse\Contracts\Data\ModelHasWarehouseData;

class ModelHasWarehouse extends BaseModuleWarehouse implements ContractsModelHasWarehouse
{
    protected string $__entity = 'ModelHasWarehouse';
    public static $model_has_warehouse_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'model_has_warehouse',
            'tags'     => ['model_has_warehouse', 'model_has_warehouse-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreModelHasWarehouse(ModelHasWarehouseData $model_has_warehouse_dto): Model{
        $add = [
            'model_type' => $model_has_warehouse_dto->model_type,
            'model_id' => $model_has_warehouse_dto->model_id,
            'warehouse_id' => $model_has_warehouse_dto->warehouse_id,
            'warehouse_type' => $model_has_warehouse_dto->warehouse_type
        ];
        if (isset($model_has_warehouse_dto->id)){
            $guard  = ['id' => $model_has_warehouse_dto->id];
            $create = [$guard, $add];
        }else{
            $create = [$add]; 
        }
        $model_has_warehouse = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($model_has_warehouse,$model_has_warehouse_dto->props);
        $model_has_warehouse->save();
        return static::$model_has_warehouse_model = $model_has_warehouse;
    }
}