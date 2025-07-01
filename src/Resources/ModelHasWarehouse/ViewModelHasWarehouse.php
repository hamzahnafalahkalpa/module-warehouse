<?php

namespace Hanafalah\ModuleWarehouse\Resources\ModelHasWarehouse;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewModelHasWarehouse extends ApiResource
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
      'id' => $this->id,
      'warehouse_type' => $this->warehouse_type,
      'warehouse_id' => $this->warehouse_id,
      'model_id' => $this->model_id,
      'model_type' => $this->model_type,
      'current' => $this->current,
      'warehouse' => $this->prop_warehouse,
      'model' => $this->prop_model
    ];
    return $arr;
  }
}
