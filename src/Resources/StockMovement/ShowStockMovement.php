<?php

namespace Hanafalah\ModuleWarehouse\Resources\StockMovement;

class ShowStockMovement extends ViewStockMovement
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'card_stock' => $this->relationValidation('cardStock', function () {
                return $this->cardStock->toShowApi();
            }),
            'item_stock' => $this->relationValidation('itemStock', function () {
                return $this->itemStock->toViewApi();
            }),
            'childs'        => $this->relationValidation('childs', function () {
                return $this->childs->transform(function ($child) {
                    return $child->toShowApi();
                });
            }),
            'batch_movements' => $this->relationValidation('batchMovements', function () {
                return $this->batchMovements->transform(function ($batchMovement) {
                    return $batchMovement->toShowApi();
                });
            }),
            'goods_receipt_unit' => $this->relationValidation('goodsReceiptUnit', function () {
                return $this->goodsReceiptUnit->toShowApi();
            }),
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);

        return $arr;
    }
}
