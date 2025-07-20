<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleItem\Contracts\Data\GoodsReceiptUnitData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\GoodsReceiptUnit as ContractGoods;

class GoodsReceiptUnit extends PackageManagement implements ContractGoods
{
    protected string $__entity = 'GoodsReceiptUnit';
    public $goods_receipt_unit_model;

    public function prepareStoreGoodsReceiptUnit(GoodsReceiptUnitData $goods_receipt_unit_dto): Model
    {
        $model = $this->usingEntity()->updateOrCreate([
            'id' => $goods_receipt_unit_dto->id ?? null
        ], [
            'card_stock_id' => $goods_receipt_unit_dto->card_stock_id,
            'unit_id'       => $goods_receipt_unit_dto->unit_id,
            'unit_name'     => $goods_receipt_unit_dto->unit_name,
            'unit_qty'      => $goods_receipt_unit_dto->unit_qty ?? 1
        ]);
        $this->fillingProps($model, $goods_receipt_unit_dto->props);
        $model->save();
        return $this->goods_receipt_unit_model = $model;
    }
}
