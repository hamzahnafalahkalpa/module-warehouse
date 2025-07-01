<?php

namespace Hanafalah\ModuleWarehouse\Resources\Room;

use Hanafalah\LaravelSupport\Resources\ApiResource;
use Hanafalah\ModuleWarehouse\Resources\Building\ViewBuilding;

class ViewRoom extends ApiResource
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
      'id'            => $this->id,
      'name'          => $this->name,
      "floor"         => $this->floor,
      "room_number"   => $this->room_number,
      "phone"         => $this->phone,
      'building'      => $this->prop_building,
      'class_room'    => $this->prop_class_room,
      'current'       => $this->current,
      'created_at'    => $this->created_at,
      'updated_at'    => $this->updated_at
    ];
    return $arr;
  }
}
