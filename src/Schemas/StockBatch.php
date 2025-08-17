<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockBatchData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\StockBatch as ContractStockBatch;

class StockBatch extends PackageManagement implements ContractStockBatch
{
    protected string $__entity = 'StockBatch';
    public $stock_batch_model;

    public function prepareStoreStockBatch(StockBatchData $stock_batch_dto): Model{
        if (isset($stock_batch_dto->id)) {
            $guard = ['id' => $stock_batch_dto->id];
        } else {
            $guard = [
                'stock_id' => $stock_batch_dto->stock_id,
                'batch_id' => $stock_batch_dto->batch_id
            ];
        }

        $model = $this->stockBatch()->firstOrCreate($guard, ['stock' => 0]);
        $model->stock += $stock_batch_dto->stock;
        $model->save();

        return $this->stock_batch_model = $model;
    }
}
