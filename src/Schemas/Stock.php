<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Stock as ContractStock;
use Hanafalah\ModuleWarehouse\Resources\Stock as ResourcesStock;

class Stock extends PackageManagement implements ContractStock
{
    protected array $__guard   = ['id', 'subject_type', 'subject_id', 'warehouse_type', 'warehouse_id'];
    protected array $__add     = ['parent_id', 'stock'];
    protected string $__entity = 'Stock';

    public static $stock_model;

    protected array $__resources = [
        'view' => ResourcesStock\ViewStock::class,
        'show' => ResourcesStock\ShowStock::class
    ];

    public function showUsingRelation(): array
    {
        return ['funding', 'subject', 'warehouse'];
    }

    public function prepareShowStock(?Model $model = null): Model
    {
        $model ??= $this->getStock();
        if (!isset($model)) {
            $id = request()->id;
            if (!request()->has('id')) throw new \Exception('No id provided', 422);

            $model = $this->StockModel()->with($this->showUsingRelation())->find($id);
        } else {
            $model->load($this->showUsingRelation());
        }
        return $model;
    }

    public function showStock(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], function () use ($model) {
            return $this->prepareShowStock($model);
        });
    }

    public function prepareStoreStock(mixed $attributes = null): Model
    {
        $attributes ??= request()->all();

        if (isset($attributes['id'])) {
            $guard = ['id' => $attributes['id']];
        } else {
            $guard = [
                'subject_type'   => $attributes['subject_type'],
                'subject_id'     => $attributes['subject_id'],
                'warehouse_type' => $attributes['warehouse_type'],
                'warehouse_id'   => $attributes['warehouse_id'],
                'funding_id'     => $attributes['funding_id'] ?? null
            ];
        }

        $stock_model = $this->StockModel()->firstOrCreate($guard, [
            'stock' => isset($attributes['stock_batches']) && count($attributes['stock_batches']) > 0 ? 0 : $attributes['stock'] ?? 0
        ]);
        if (isset($attributes['stock_batches']) && count($attributes['stock_batches']) > 0) {
            $batch_schema = $this->schemaContract('batch');
            foreach ($attributes['stock_batches'] as $batch) {
                $batch_model = $batch_schema->prepareStoreBatch($batch);

                $stock_batch = $stock_model->stockBatches()->firstOrCreate([
                    'batch_id' => $batch_model->getKey(),
                    'stock_id' => $stock_model->getKey()
                ], [
                    'stock' => $batch['stock'] ?? 0
                ]);
                if (!$stock_batch->wasRecentlyCreated) $stock_model->stock += $batch['stock'] ?? 0;
                $stock_batch->save();
            }
            $stock_model->save();
        }
        return static::$stock_model = $stock_model;
    }

    public function storeStock(): array
    {
        $this->booting();
        return $this->transaction(function () {
            return $this->showStock($this->prepareStoreStock());
        });
    }

    public function prepareViewStockList(?array $attributes = null, mixed $conditionals = null): Collection
    {
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
            })
            ->get();
    }

    public function viewStock(): array
    {
        return $this->transforming($this->__resources['view'], function () {
            return $this->prepareViewStockList();
        });
    }

    public function getStock(): ?Model
    {
        return static::$stock_model;
    }
}
