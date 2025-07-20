<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Batch as ContractsBatch;
use Hanafalah\ModuleWarehouse\Resources\Batch as ResourcesBatch;

class Batch extends PackageManagement implements ContractsBatch
{
    protected string $__entity = 'Batch';
    public $batch_model;

    public function prepareStoreBatch(?array $attributes = null): Model{
        $attributes ??= request()->all();

        $batch = $this->batch()->firstOrCreate([
            'batch_no'   => $attributes['batch_no'],
            'expired_at' => $attributes['expired_at']
        ]);

        static::$batch_model = $batch;
        return $batch;
    }
}
