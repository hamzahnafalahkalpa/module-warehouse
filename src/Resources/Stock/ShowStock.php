<?php

namespace Hanafalah\ModuleWarehouse\Resources\Stock;

use Hanafalah\LaravelSupport\Resources\ApiResource;
use Hanafalah\ModuleWarehouse\Resources\Building\ViewBuilding;

class ShowStock extends ViewStock
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
      'subject'    => $this->relationValidation('subject', function () {
        return $this->subject->toViewApi()->resolve();
      }),
      'funding'    => $this->relationValidation('funding', function () {
        return $this->funding->toShowApi()->resolve();
      }),
      'warehouse'  => $this->relationValidation('warehouse', function () {
        return $this->warehouse->toViewApi()->resolve();
      }),
      'stock_batches'  => $this->relationValidation('stockBatches', function () {
        return $this->stockBatches->transform(function ($stockBatch) {
          return $stockBatch->toShowApi()->resolve();
        });
      })
    ];
    $arr = $this->mergeArray(parent::toArray($request), $arr);

    return $arr;
  }
}
