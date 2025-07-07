<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

//use Hanafalah\ModuleWarehouse\Contracts\Data\WarehouseItemUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\WarehouseItemData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleWarehouse\Schemas\WarehouseItem
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateWarehouseItem(?WarehouseItemData $warehouse_item = null)
 * @method Model prepareUpdateWarehouseItem(WarehouseItemData $warehouse_item)
 * @method bool deleteWarehouseItem()
 * @method bool prepareDeleteWarehouseItem(? array $attributes = null)
 * @method mixed getWarehouseItem()
 * @method ?Model prepareShowWarehouseItem(?Model $model = null, ?array $attributes = null)
 * @method array showWarehouseItem(?Model $model = null)
 * @method Collection prepareViewWarehouseItemList()
 * @method array viewWarehouseItemList()
 * @method LengthAwarePaginator prepareViewWarehouseItemPaginate(PaginateData $paginate_dto)
 * @method array viewWarehouseItemPaginate(?PaginateData $paginate_dto = null)
 * @method array storeWarehouseItem(?WarehouseItemData $warehouse_item = null)
 * @method Collection prepareStoreMultipleWarehouseItem(array $datas)
 * @method array storeMultipleWarehouseItem(array $datas)
 */

interface WarehouseItem extends DataManagement
{
    public function prepareStoreWarehouseItem(WarehouseItemData $warehouse_item): Model;
}