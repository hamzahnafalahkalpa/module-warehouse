<?php

namespace Hanafalah\ModuleWarehouse\Resources\StockBatch;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewStockBatch extends ApiResource
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
      'stock'          => $this->stock,
      'stock_spell'    => $this->stock,
      'batch'          => $this->relationValidation('batch', function () {
        return $this->batch->toViewApi()->resolve();
      }),
      'created_at'     => $this->created_at,
      'updated_at'     => $this->updated_at
    ];

    return $arr;
  }
}
