<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\WarehouseItemData as DataWarehouseItemData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class WarehouseItemData extends Data implements DataWarehouseItemData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('warehouse_type')]
    #[MapName('warehouse_type')]
    public string $warehouse_type;

    #[MapInputName('warehouse_id')]
    #[MapName('warehouse_id')]
    public mixed $warehouse_id;

    #[MapInputName('item_type')]
    #[MapName('item_type')]
    public mixed $item_type;

    #[MapInputName('item_id')]
    #[MapName('item_id')]
    public mixed $item_id;

    #[MapInputName('flag')]
    #[MapName('flag')]
    public string $flag;
    
    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        $attributes['item_type'] ??= 'Item'; 
        $attributes['warehouse_type'] ??= 'Room'; 
    }

    public static function after(self $data): self{
        $new = static::new();

        $props = &$data->props;

        $item = $new->{$data->item_type.'Model'}();
        $item = isset($data->item_id) ? $item->findOrFail($data->item_id) : $item;
        $props['prop_item'] = $item->toViewApi()->resolve();

        $warehouse = $new->{$data->warehouse_type.'Model'}();
        $warehouse = isset($data->warehouse_id) ? $warehouse->findOrFail($data->warehouse_id) : $warehouse;
        $props['prop_warehouse'] = $warehouse->toViewApi()->resolve();
        return $data;
    }
}