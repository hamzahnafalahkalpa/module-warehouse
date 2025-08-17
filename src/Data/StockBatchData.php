<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\BatchData;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockBatchData as DataStockBatchData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class StockBatchData extends Data implements DataStockBatchData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('stock_id')]
    #[MapName('stock_id')]
    public mixed $stock_id;

    #[MapInputName('batch_id')]
    #[MapName('batch_id')]
    public mixed $batch_id;

    #[MapInputName('batch')]
    #[MapName('batch')]
    public ?BatchData $batch = null;

    #[MapInputName('stock')]
    #[MapName('stock')]
    public ?int $stock = 0;
}