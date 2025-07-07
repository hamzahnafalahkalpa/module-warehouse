<?php

namespace Hanafalah\ModuleWarehouse\Resources\ModelHasRoom;

use Hanafalah\ModuleWarehouse\Resources\ModelHasWarehouse\ViewModelHasWarehouse;

class ViewModelHasRoom extends ViewModelHasWarehouse
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
      'room' => $this->prop_room
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
