<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleItem\Contracts\Data\StockBatchData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\StockBatch as ContractStockBatch;

class StockBatch extends PackageManagement implements ContractStockBatch
{
    protected string $__entity = 'StockBatch';
    public static $stock_batch_model;

    protected function viewUsingRelation(): array{
        return [];
    }

    protected function showUsingRelation(): array{
        return [];
    }

    public function getStockBatch(): mixed{
        return static::$stock_batch_model;
    }

    public function prepareStoreStockBatch(StockBatchData $stock_batch_dto): Model{
        if (isset($stock_batch_dto->id)) {
            $guard = ['id' => $stock_batch_dto->id];
        } else {
            if (!isset($stock_batch_dto->stock_id)) throw new \Exception('stock_id is required');
            if (!isset($stock_batch_dto->batch_id)) throw new \Exception('batch_id is required');
            $guard = [
                'stock_id' => $stock_batch_dto->stock_id,
                'batch_id' => $stock_batch_dto->batch_id
            ];
        }

        $model = $this->stockBatch()->firstOrCreate($guard, ['stock' => 0]);
        $model->stock += $stock_batch_dto->stock;
        $model->save();

        return static::$stock_batch_model = $model;
    }

    public function storeStockBatch(?StockBatchData $stock_batch_dto = null): array{
        return $this->transaction(function() use ($stock_batch_dto){
            return $this->showStockBatch($this->prepareStoreStockBatch($stock_batch_dto ?? $this->requestDTO(StockBatchData::class)));
        });
    }

    public function prepareStockBatchList(?array $attributes = null): Collection{
        $attributes ??= request()->all();
        if (!isset($attributes['stock_id'])) throw new \Exception('stock_id is required');

        $model = $this->stockBatch()->where('stock_id', $attributes['stock_id'])->get();
        return static::$stock_batch_model = $model;
    }

    public function viewStockBatchList(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareStockBatchList();
        });
    }

    public function stockBatch(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->StockBatchModel()->withParameters()->conditionals($this->mergeCondition($conditionals ?? []));
    }
}
