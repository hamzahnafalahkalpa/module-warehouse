<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\GoodsReceiptUnit as ContractGoods;
use Hanafalah\ModuleWarehouse\Resources\GoodsReceiptUnit as ResourcesGoods;

class GoodsReceiptUnit extends PackageManagement implements ContractGoods
{
    protected string $__entity = 'GoodsReceiptUnit';
    public static $goods_receipt_unit_model;

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
}
