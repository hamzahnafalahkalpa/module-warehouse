<?php

namespace Hanafalah\ModuleWarehouse\Resources\WarehouseItem;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewWarehouseItem extends ApiResource
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
      'warehouse_id' => $this->warehouse_id,
      'warehouse_type' => $this->warehouse_type,
      'item_type' => $this->item_type,
      'item_id' => $this->item_id,
      'item'    => $this->prop_item,
      'flag'    => $this->flag
    ];
    return $arr;
  }
}
