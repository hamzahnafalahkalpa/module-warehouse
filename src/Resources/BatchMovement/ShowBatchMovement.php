<?php

namespace Hanafalah\ModuleWarehouse\Resources\BatchMovement;

class ShowBatchMovement extends ViewBatchMovement
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
      'stock_batch' => $this->relationValidation('stockBatch', function () {
        return $this->stockBatch->toShowApi()->resolve();
      })
    ];
    $arr = $this->mergeArray(parent::toArray($request), $arr);

    return $arr;
  }
}
