<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleWarehouse\Contracts\Data\BatchData as DataBatchData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class BatchData extends Data implements DataBatchData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('batch_no')]
    #[MapName('batch_no')]
    public ?string $batch_no = null;

    #[MapInputName('expired_at')]
    #[MapName('expired_at')]
    #[DateFormat('Y-m-d')]
    public ?string $expired_at = null;
}