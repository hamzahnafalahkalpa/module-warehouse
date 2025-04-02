<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\{
    Contracts\Schemas\BatchMovement as ContractsBatchMovement,
    Resources\BatchMovement as ResourcesBatchMovement
};

class BatchMovement extends PackageManagement implements ContractsBatchMovement
{
    protected array $__guard   = [];
    protected array $__add     = [];
    protected string $__entity = 'BatchMovement';

    public static $batch_movement_model;

    protected array $__resources = [
        'view' => ResourcesBatchMovement\ViewBatchMovement::class,
        'show' => ResourcesBatchMovement\ShowBatchMovement::class
    ];

    public function getBatchMovement(): ?Model
    {
        return static::$batch_movement_model;
    }

    public function prepareStoreBatchMovement(?array $attributes = null): Model
    {
        $attributes ??= request()->all();
        if (isset($attributes['id'])) {
            $guard = ['id' => $attributes['id']];
        } else {
            if (!isset($attributes['batch_id'])) {
                if (isset($attributes['batch_no']) && $attributes['expired_at']) {
                    $batch = $this->BatchModel()->firstOrCreate([
                        'expired_at' => $attributes['expired_at'],
                        'batch_no'   => $attributes['batch_no']
                    ]);
                    $attributes['batch_id'] = $batch->getKey();
                } else {
                    throw new \Exception('Batch ID not found');
                }
            }
            if (!isset($attributes['stock_movement_id'])) throw new \Exception('Stock Movement ID not found');

            if (!isset($attributes['stock_batch_id'])) {
                if (!isset($attributes['stock_id'])) throw new \Exception('Stock ID not found');
                $stock = $this->StockModel()->find($attributes['stock_id']);
                $stock_batch = $stock->stockBatch()->firstOrCreate([
                    'batch_id' => $attributes['batch_id'],
                    'stock_id' => $stock->getKey()
                ], [
                    'stock' => 0
                ]);
                $attributes['stock_batch_id'] = $stock_batch->getKey();
            }

            $guard = [
                'stock_batch_id'     => $attributes['stock_batch_id'],
                'batch_id'           => $attributes['batch_id'],
                'stock_movement_id'  => $attributes['stock_movement_id'],
            ];
        }
        $batch_movement = $this->BatchMovementModel()->updateOrCreate($guard, [
            'qty' => $attributes['qty'] ?? 0,
        ]);
        return static::$batch_movement_model = $batch_movement;
    }

    public function batchMovement(): Builder
    {
        $this->booting();
        return $this->BatchMovementModel()->withParameters();
    }
}
