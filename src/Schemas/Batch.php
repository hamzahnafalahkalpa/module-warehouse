<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\BatchData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Batch as ContractsBatch;
use Hanafalah\ModuleWarehouse\Resources\Batch as ResourcesBatch;

class Batch extends PackageManagement implements ContractsBatch
{
    protected string $__entity = 'Batch';
    public $batch_model;

    public function prepareStoreBatch(BatchData $batch_dto): Model{
        $batch = $this->batch()->firstOrCreate([
            'batch_no'   => $batch_dto->batch_no,
            'expired_at' => $batch_dto->expired_at
        ]);
        return $this->batch_model = $batch;
    }
}
