<?php

namespace Zahzah\ModuleWarehouse\Resources\BatchMovement;

use Zahzah\LaravelSupport\Resources\ApiResource;

class ViewBatchMovement extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(\Illuminate\Http\Request $request) : array{
        $arr = [
            'id'    => $this->id,
            'parent_id' => $this->parent_id,
            'batch' => $this->relationValidation('batch',function(){
                return $this->batch->toViewApi();
            }),
            'stock_batch' => $this->relationValidation('stockBatch',function(){
                return $this->stockBatch->toViewApi();
            }),
            'qty'   => $this->qty,
            'opening_stock' => $this->opening_stock,
            'closing_stock' => $this->closing_stock,
            'changes_stock' => abs($this->closing_stock - $this->opening_stock)
        ];
        
        return $arr;
  }
}