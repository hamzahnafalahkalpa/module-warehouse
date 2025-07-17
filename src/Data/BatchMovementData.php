<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\BatchMovementData as DataBatchMovementData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class BatchMovementData extends Data implements DataBatchMovementData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;

    #[MapInputName('stock_movement_id')]
    #[MapName('stock_movement_id')]
    public mixed $stock_movement_id;

    #[MapInputName('batch_id')]
    #[MapName('batch_id')]
    public mixed $batch_id;

    #[MapInputName('qty')]
    #[MapName('qty')]
    public float $qty;

    #[MapInputName('batch')]
    #[MapName('batch')]
    public ?array $batch = null;

    #[MapInputName('stock_batch_id')]
    #[MapName('stock_batch_id')]
    public mixed $stock_batch_id = null;

    #[MapInputName('opening_stock')]
    #[MapName('opening_stock')]
    public ?float $openingStock = null;

    #[MapInputName('closing_stock')]
    #[MapName('closing_stock')]
    public ?float $closingStock = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(BatchMovementData $data): BatchMovementData{
        $data->props['prop_batch'] = [
            'id'          => $data->qty_unit_id ?? null,
            'batch_no'    => $data->batch['batch_no'] ?? null,
            'expired_at'  => $data->batch['expired_at'] ?? null,
        ];
        if (isset($data->props['prop_batch']['id'])){
            $batch = self::new()->BatchModel()->findOrFail($data->props['prop_batch']['id']);
            $data->props['prop_batch']['batch_no']   ??= $batch->batch_no;
            $data->props['prop_batch']['expired_at'] ??= $batch->expired_at;
        }
        return $data;
    }
}