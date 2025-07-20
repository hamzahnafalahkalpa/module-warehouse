<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\{
    Contracts\Schemas\BatchMovement as ContractsBatchMovement,
};
use Illuminate\Database\Eloquent\ModelInspector;

class BatchMovement extends PackageManagement implements ContractsBatchMovement
{
    protected string $__entity = 'BatchMovement';
    public $batch_movement_model;

    public function prepareStoreBatchMovement(?array $attributes = null): ModelInspector{
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
        return $this->batch_movement_model = $batch_movement;
    }
}
