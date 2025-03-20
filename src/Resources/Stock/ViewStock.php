<?php

namespace Hanafalah\ModuleWarehouse\Resources\Stock;

use Hanafalah\LaravelSupport\Resources\ApiResource;
use Hanafalah\ModuleWarehouse\Resources\Building\ViewBuilding;

class ViewStock extends ApiResource
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
      'id'             => $this->id,
      'funding_id'     => $this->funding_id,
      'parent_id'      => $this->parent_id ?? null,
      'subject_type'   => $this->subject_type,
      'subject_id'     => $this->subject_id,
      'warehouse_type' => $this->warehouse_type,
      'warehouse_id'   => $this->warehouse_id,
      'stock'          => $this->stock,
      'stock_spell'    => ($this->stock % 1 == 0) ? (int) $this->stock : number_format($this->stock, 2, '.', ''),
      'stock_batches'  => $this->relationValidation('stockBatches', function () {
        return $this->stockBatches->transform(function ($stockBatch) {
          return $stockBatch->toViewApi();
        });
      }),
      'funding'    => $this->relationValidation('funding', function () {
        return $this->funding->toViewApi();
      }),
      'childs'         => $this->relationValidation('childs', function () {
        $childs = $this->childs;
        return $childs->transform(function ($child) {
          return new static($child);
        });
      })
    ];

    return $arr;
  }
}
