<?php

namespace Hanafalah\ModuleWarehouse\Resources\ModelHasRoom;

use Hanafalah\ModuleWarehouse\Resources\ModelHasWarehouse\ShowModelHasWarehouse;

class ShowModelHasRoom extends ViewModelHasRoom
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [];
    $show = $this->resolveNow(new ShowModelHasWarehouse($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
