<?php

namespace Hanafalah\ModuleWarehouse\Resources\GoodsReceiptUnit;

use Hanafalah\LaravelSupport\Resources\ApiResource;
use Hanafalah\ModuleWarehouse\Resources\Building\ViewBuilding;

class ViewGoodsReceiptUnit extends ApiResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $props = $this->getOriginal()['props'];
    $arr = [
      'id'            => $this->id,
      'card_stock_id' => $this->card_stock_id,
      'card_stock'    => $this->relationValidation('cardStock', function () {
        return $this->cardStock->toViewApi()->resolve();
      }),
      'unit_id'       => $this->unit_id,
      'unit'          => $this->relationValidation('unit', function () {
        return $this->unit->toViewApi()->resolve();
      }),
      'unit_name'     => $this->unit_name,
      'unit_qty'      => $this->unit_qty,
      'props'         => $props == [] ? null : $props
    ];

    return $arr;
  }
}
