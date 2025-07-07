<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Hanafalah\ModuleWarehouse\Contracts\Data\ModelHasWarehouseData;
//use Hanafalah\ModuleWarehouse\Contracts\Data\ModelHasWarehouseUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleWarehouse\Schemas\ModelHasWarehouse
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateModelHasWarehouse(?ModelHasWarehouseData $model_has_warehouse_dto = null)
 * @method Model prepareUpdateModelHasWarehouse(ModelHasWarehouseData $model_has_warehouse_dto)
 * @method bool deleteModelHasWarehouse()
 * @method bool prepareDeleteModelHasWarehouse(? array $attributes = null)
 * @method mixed getModelHasWarehouse()
 * @method ?Model prepareShowModelHasWarehouse(?Model $model = null, ?array $attributes = null)
 * @method array showModelHasWarehouse(?Model $model = null)
 * @method Collection prepareViewModelHasWarehouseList()
 * @method array viewModelHasWarehouseList()
 * @method LengthAwarePaginator prepareViewModelHasWarehousePaginate(PaginateData $paginate_dto)
 * @method array viewModelHasWarehousePaginate(?PaginateData $paginate_dto = null)
 * @method array storeModelHasWarehouse(?ModelHasWarehouseData $model_has_warehouse_dto = null)
 * @method Collection prepareStoreMultipleModelHasWarehouse(array $datas)
 * @method array storeMultipleModelHasWarehouse(array $datas)
 */

interface ModelHasWarehouse extends DataManagement
{
    public function prepareStoreModelHasWarehouse(ModelHasWarehouseData $model_has_warehouse_dto): Model;
}