<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Stock as ContractStock;

class Stock extends PackageManagement implements ContractStock
{
    protected string $__entity = 'Stock';
    public static $stock_model;

    protected function viewUsingRelation(): array{
        return [];
    }

    protected function showUsingRelation(): array{
        return ['funding', 'subject', 'warehouse'];
    }

    public function getStock(): ?Model{
        return static::$stock_model;
    }

    public function prepareShowStock(?Model $model = null, ? array $attributes = null): Model{
        $attributes ??= \request()->all();
        $model      ??= $this->getStock();
        if (!isset($model)) {
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('No id provided', 422);

            $model = $this->StockModel()->with($this->showUsingRelation())->findOrFail($id);
        } else {
            $model->load($this->showUsingRelation());
        }
        return $model;
    }

    public function showStock(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowStock($model);
        });
    }

    public function prepareStoreStock(StockData $stock_dto): Model{
        if (isset($stock_dto->id)) {
            $guard = ['id' => $stock_dto->id];
        } else {
            $guard = [
                'subject_type'   => $stock_dto->subject_type,
                'subject_id'     => $stock_dto->subject_id,
                'warehouse_type' => $stock_dto->warehouse_type,
                'warehouse_id'   => $stock_dto->warehouse_id,
                'funding_id'     => $stock_dto->funding_id ?? null
            ];
        }

        $stock_model = $this->StockModel()->firstOrCreate($guard, [
            'stock' => isset($stock_dto->stock_batches) && count($stock_dto->stock_batches) > 0 ? 0 : $stock_dto->stock ?? 0
        ]);
        if (isset($stock_dto->stock_batches) && count($stock_dto->stock_batches) > 0) {
            $batch_schema = $this->schemaContract('batch');
            foreach ($stock_dto->stock_batches as $batch) {
                $batch_model = $batch_schema->prepareStoreBatch($batch);

                $stock_batch = $stock_model->stockBatches()->firstOrCreate([
                    'batch_id' => $batch_model->getKey(),
                    'stock_id' => $stock_model->getKey()
                ], [
                    'stock' => $batch->stock ?? 0
                ]);
                if (!$stock_batch->wasRecentlyCreated) $stock_model->stock += $batch->stock ?? 0;
                $stock_batch->save();
            }
            $stock_model->save();
        }
        return static::$stock_model = $stock_model;
    }

    public function storeStock(): array{
        return $this->transaction(function () {
            return $this->showStock($this->prepareStoreStock());
        });
    }

    public function prepareViewStockList(?array $attributes = null, mixed $conditionals = null): Collection{
        $attributes ??= request()->all();
        return $this->stock($conditionals)
            ->when(isset($attributes['warehouse_type']) && isset($attributes['warehouse_id']), function ($query) use ($attributes) {
                $query->where([
                    ['warehouse_type', $attributes['warehouse_type']],
                    ['warehouse_id', $attributes['warehouse_id']]
                ]);
            })
            ->when(isset($attributes['subject_type']) && isset($attributes['subject_id']), function ($query) use ($attributes) {
                $query->where([
                    ['subject_type', $attributes['subject_type']],
                    ['subject_id', $attributes['subject_id']]
                ]);
            })->get();
    }

    public function viewStock(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareViewStockList();
        });
    }
}
