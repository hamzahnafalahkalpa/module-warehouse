<?php

namespace Hanafalah\ModuleWarehouse\Resources\Room;

class ShowRoom extends ViewRoom
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
      'model_has_rooms' => $this->relationValidation('modelHasRooms',function(){
        return $this->modelHasRooms->transform(function($modelHasRoom){
          return $modelHasRoom->toViewApi()->resolve();
        });
      }),
      'warehouse_items' => $this->relationValidation('warehouseItems',function(){
        return $this->warehouseItems->transform(function($warehouseItem){
          return $warehouseItem->toViewApi()->resolve();
        });
      })
    ];
    $arr = $this->mergeArray(parent::toArray($request), $arr);
    return $arr;
  }
}
