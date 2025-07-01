<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleItem\Contracts\Data\GoodsReceiptUnitData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleWarehouse\Schemas\GoodsReceiptUnit
 * @method bool deleteGoodsReceiptUnit()
 * @method bool prepareDeleteGoodsReceiptUnit(? array $attributes = null)
 * @method mixed getGoodsReceiptUnit()
 * @method ?Model prepareShowGoodsReceiptUnit(?Model $model = null, ?array $attributes = null)
 * @method array showGoodsReceiptUnit(?Model $model = null)
 * @method Collection prepareViewGoodsReceiptUnitList()
 * @method array viewGoodsReceiptUnitList()
 * @method LengthAwarePaginator prepareViewGoodsReceiptUnitPaginate(PaginateData $paginate_dto)
 * @method Model prepareStoreGoodsReceiptUnit(GoodsReceiptUnitData $goods_receipt_unit_dto)
 * @method array storeGoodsReceiptUnit(? GoodsReceiptUnitData $goods_receipt_unit_dto = null)
 * @method array viewGoodsReceiptUnitPaginate(?PaginateData $paginate_dto = null)
 * @method Builder goodsReceiptUnit(mixed $conditionals = null)
 */
interface GoodsReceiptUnit extends DataManagement {
    public function prepareStoreGoodsReceiptUnit(GoodsReceiptUnitData $goods_receipt_unit_dto): Model;
}
