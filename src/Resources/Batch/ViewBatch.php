<?php

namespace Zahzah\ModuleWarehouse\Resources\Batch;

use Zahzah\LaravelSupport\Resources\ApiResource;

class ViewBatch extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request) : array{
        $arr = [
            'id'         => $this->id,
            'batch_no'   => $this->batch_no,
            'expired_at' => $this->expired_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
        
        return $arr;
  }
}