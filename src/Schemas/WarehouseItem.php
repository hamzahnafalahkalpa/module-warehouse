<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleWarehouse\{
    Supports\BaseModuleWarehouse
};
use Hanafalah\ModuleWarehouse\Contracts\Schemas\WarehouseItem as ContractsWarehouseItem;
use Hanafalah\ModuleWarehouse\Contracts\Data\WarehouseItemData;

class WarehouseItem extends BaseModuleWarehouse implements ContractsWarehouseItem
{
    protected string $__entity = 'WarehouseItem';
    public $warehouse_item_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'warehouse_item',
            'tags'     => ['warehouse_item', 'warehouse_item-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreWarehouseItem(WarehouseitemData $warehouse_item_dto): Model{
        $add = [
            'flag' => $warehouse_item_dto->flag,
            'warehouse_id' => $warehouse_item_dto->warehouse_id,
            'warehouse_type' => $warehouse_item_dto->warehouse_type,
            'item_type' => $warehouse_item_dto->item_type,
            'item_id' => $warehouse_item_dto->item_id
        ];
        if (isset($warehouse_item_dto->id)){
            $guard  = ['id' => $warehouse_item_dto->id];
            $create = [$guard, $add];
        }else{
            $create = [$add];
        }

        $warehouse_item = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($warehouse_item,$warehouse_item_dto->props);
        $warehouse_item->save();
        return $this->warehouse_item_model = $warehouse_item;
    }
}