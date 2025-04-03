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
      'name_spell'    => $this->name . " Lantai " . $this->floor,
      "floor"         => $this->floor,
      'is_supplier'   => $this->is_supplier == 1 ? true : false,
      "phone"         => $this->phone,
      'building'      => $this->relationValidation('building', function () {
        return ViewBuilding($this->building);
      }),
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
    if (isset($this->current)) $arr['current'] = $this->current;

    return $arr;
  }
}
