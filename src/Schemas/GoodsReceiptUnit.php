<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\GoodsReceiptUnit as ContractGoods;
use Hanafalah\ModuleWarehouse\Resources\GoodsReceiptUnit as ResourcesGoods;

class GoodsReceiptUnit extends PackageManagement implements ContractGoods
{
    protected array $__guard   = [];
    protected array $__add     = [];
    protected string $__entity = 'GoodsReceiptUnit';

    public static $goods_receipt_unit_model;

    protected array $__resources = [
        'view' => ResourcesGoods\ViewGoodsReceiptUnit::class,
        'show' => ResourcesGoods\ShowGoodsReceiptUnit::class
    ];

    public function getGoodsReceiptUnit(): ?Model
    {
        return static::$goods_receipt_unit_model;
    }

    public function showUsingRelation(): array
    {
        return [];
    }

    public function prepareShowGoodsReceiptUnit(?Model $model = null, ?array $attributes = null): Model
    {
        $attributes ??= request()->all();

        $model ??= $this->getGoodsReceiptUnit();
        if (!isset($model)) {
            $id = request()->id;
            if (!request()->has('id')) throw new \Exception('No id provided', 422);
            $model = $this->goodsReceiptUnit()->with($this->showUsingRelation())->find($id);
        } else {
            $model->load($this->showUsingRelation());
        }
        return static::$goods_receipt_unit_model = $model;
    }

    public function showGoodsReceiptUnit(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], function () use ($model) {
            return $this->prepareShowGoodsReceiptUnit($model);
        });
    }

    public function prepareStoreGoodsReceiptUnit(?array $attributes = null): Model
    {
        $attributes ??= request()->all();
        if (!isset($attributes['card_stock_id'])) throw new \Exception('card_stock_id is required');
        if (!isset($attributes['unit_id'])) throw new \Exception('unit_id is required');

        $unit = $this->ItemStuffModel()->findOrFail($attributes['unit_id']);
        $model = $this->GoodsReceiptUnitModel()->updateOrCreate([
            'id' => $attributes['id'] ?? null
        ], [
            'card_stock_id' => $attributes['card_stock_id'],
            'unit_id'       => $unit->getKey(),
            'unit_name'     => $unit->name,
            'unit_qty'      => $attributes['unit_qty'] ?? 1
        ]);
        return static::$goods_receipt_unit_model = $model;
    }

    public function storeGoodsReceiptUnit(): array
    {
        return $this->transaction(function () {
            return $this->showGoodsReceiptUnit($this->prepareStoreGoodsReceiptUnit());
        });
    }

    public function goodsReceiptUnit(): Builder
    {
        $this->booting();

        return $this->GoodsReceiptUnitModel()->withParameters();
    }
}
