<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockData as DataStockData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\RequiredWithout;

class StockData extends Data implements DataStockData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('subject_type')]
    #[MapName('subject_type')]
    #[RequiredWithout('id')]
    public ?string $subject_type = null;

    #[MapInputName('subject_id')]
    #[MapName('subject_id')]
    #[RequiredWithout('id')]
    public mixed $subject_id = null;

    #[MapInputName('warehouse_type')]
    #[MapName('warehouse_type')]
    #[RequiredWithout('id')]
    public ?string $warehouse_type = null;

    #[MapInputName('warehouse_id')]
    #[MapName('warehouse_id')]
    #[RequiredWithout('id')]
    public mixed $warehouse_id = null;

    #[MapInputName('funding_id')]
    #[MapName('funding_id')]
    #[RequiredWithout('id')]
    public mixed $funding_id = null;

    #[MapInputName('procurement_type')]
    #[MapName('procurement_type')]
    #[RequiredWithout('id')]
    public ?string $procurement_type = null;

    #[MapInputName('procurement_id')]
    #[MapName('procurement_id')]
    #[RequiredWithout('id')]
    public mixed $procurement_id = null;

    #[MapInputName('stock_batches')]
    #[MapName('stock_batches')]
    #[DataCollectionOf(StockBatchData::class)]
    public ?array $stock_batches = [];

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = [];
}