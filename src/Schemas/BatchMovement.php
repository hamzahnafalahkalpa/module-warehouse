<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\{
    Contracts\Schemas\BatchMovement as ContractsBatchMovement,
};
use Hanafalah\ModuleWarehouse\Contracts\Data\BatchMovementData;
use Illuminate\Database\Eloquent\Model;

class BatchMovement extends PackageManagement implements ContractsBatchMovement
{
    protected string $__entity = 'BatchMovement';
    public $batch_movement_model;

    public function prepareStoreBatchMovement(BatchMovementData $batch_movement_dto): Model{
        if (isset($batch_movement_dto->id)) {
            $guard = ['id' => $batch_movement_dto->id];
        } else {
            if (isset($batch_movement_dto->batch)) {
                $batch = $this->schemaContract('batch')->prepareStoreBatch($batch_movement_dto->batch);
                $batch_movement_dto->batch_id = $batch->getKey();
                $batch_movement_dto->props['porp_batch'] = $batch->toViewApiExcepts('created_at', 'updated_at');
            }

            if (!isset($batch_movement_dto->stock_batch_id)) {
                $stock_batch = &$batch_movement_dto->stock_batch;
                if (!isset($stock_batch->stock_id)) throw new \Exception('Stock ID not found');
                $stock_batch->batch_id = $batch_movement_dto->batch_id;                
                $stock_batch_model = $this->schemaContract('stock_batch')->prepareStoreStockBatch($stock_batch);
                $batch_movement_dto->stock_batch_id = $stock_batch_model->getKey();
            }

            $guard = [
                'stock_batch_id'     => $batch_movement_dto->stock_batch_id,
                'batch_id'           => $batch_movement_dto->batch_id,
                'stock_movement_id'  => $batch_movement_dto->stock_movement_id,
            ];
        }
        $batch_movement = $this->BatchMovementModel()->updateOrCreate($guard, [
            'qty' => $batch_movement_dto->qty ?? 0,
        ]);
        $this->fillingProps($batch_movement, $batch_movement_dto->props);
        $batch_movement->save();
        return $this->batch_movement_model = $batch_movement;
    }
}
