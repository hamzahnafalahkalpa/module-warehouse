<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Batch as ContractsBatch;
use Hanafalah\ModuleWarehouse\Resources\Batch as ResourcesBatch;

class Batch extends PackageManagement implements ContractsBatch
{
    protected array $__guard   = ['batch_no', 'expired_at'];
    protected array $__add     = [];
    protected string $__entity = 'Batch';

    public static $batch_model;

    protected array $__resources = [
        'view' => ResourcesBatch\ViewBatch::class
    ];

    public function prepareStoreBatch(?array $attributes = null): Model
    {
        $attributes ??= request()->all();

        $batch = $this->batch()->firstOrCreate([
            'batch_no'   => $attributes['batch_no'],
            'expired_at' => $attributes['expired_at']
        ]);

        static::$batch_model = $batch;
        return $batch;
    }

    public function getBatch(): ?Model
    {
        return static::$batch_model;
    }

    public function batch(mixed $conditionals = null): Builder
    {
        $this->booting();
        return $this->BatchModel()->conditionals($conditionals);
    }
}
