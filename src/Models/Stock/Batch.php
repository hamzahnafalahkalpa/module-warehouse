<?php

namespace Zahzah\ModuleWarehouse\Models\Stock;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Zahzah\ModuleWarehouse\Resources\Batch\{
    ViewBatch 
};
use Zahzah\LaravelSupport\Models\BaseModel;

class Batch extends BaseModel {
    use HasUlids;

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $list       = ['id','batch_no','expired_at'];
    protected $show       = [];

    public function toShowApi(){
        return new ViewBatch($this);
    }

    public function toViewApi(){
        return new ViewBatch($this);
    }
}
