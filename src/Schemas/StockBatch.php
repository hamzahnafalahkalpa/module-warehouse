<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\StockBatch as ContractStockBatch;
use Hanafalah\ModuleWarehouse\Resources\StockBatch as ResourcesStockBatch;

class StockBatch extends PackageManagement implements ContractStockBatch
{
    protected array $__guard   = [];
    protected array $__add     = [];
    protected string $__entity = 'StockBatch';

    public static $stock_batch_model;

    protected array $__resources = [
        'view' => ResourcesStockBatch\ViewStockBatch::class
    ];

    public function getStockBatch(): mixed
    {
        return static::$stock_batch_model;
    }

    public function prepareStoreStockBatch(?array $attributes = null): Model
    {
        $attributes ??= request()->all();
        if (isset($attributes['id'])) {
            $guard = ['id' => $attributes['id']];
        } else {
            if (!isset($attributes['stock_id'])) throw new \Exception('stock_id is required');
            if (!isset($attributes['batch_id'])) throw new \Exception('batch_id is required');
            $guard = [
                'stock_id' => $attributes['stock_id'],
                'batch_id' => $attributes['batch_id']
            ];
        }

        $model = $this->stockBatch()->firstOrCreate($guard, [
            'stock' => 0
        ]);
        $model->stock += $attributes['stock'];
        $model->save();

        return static::$stock_batch_model = $model;
    }

    public function storeStockBatch(): array
    {
        return $this->transaction(function () {
            return $this->showStockBatch($this->prepareStoreStockBatch());
        });
    }

    public function prepareStockBatchList(?array $attributes = null): Collection
    {
        $attributes ??= request()->all();
        if (!isset($attributes['stock_id'])) throw new \Exception('stock_id is required');

        $model = $this->stockBatch()->where('stock_id', $attributes['stock_id'])->get();
        return static::$stock_batch_model = $model;
    }

    public function viewStockBatchList(): array
    {
        return $this->transforming($this->__resources['view'], function () {
            return $this->prepareStockBatchList();
        });
    }

    public function stockBatch(mixed $conditionals = null): Builder
    {
        $this->booting();

        return $this->StockBatchModel()->withParameters()->conditionals($conditionals);
    }
}
