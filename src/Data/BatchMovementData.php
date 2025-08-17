<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\BatchData;
use Hanafalah\ModuleWarehouse\Contracts\Data\BatchMovementData as DataBatchMovementData;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockBatchData;
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
    public ?BatchData $batch = null;

    #[MapInputName('stock_batch_id')]
    #[MapName('stock_batch_id')]
    public mixed $stock_batch_id = null;

    #[MapInputName('stock_batch')]
    #[MapName('stock_batch')]
    public ?StockBatchData $stock_batch = null;

    #[MapInputName('opening_stock')]
    #[MapName('opening_stock')]
    public ?float $openingStock = null;

    #[MapInputName('closing_stock')]
    #[MapName('closing_stock')]
    public ?float $closingStock = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}