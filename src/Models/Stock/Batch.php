<?php

namespace Hanafalah\ModuleWarehouse\Models\Stock;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\ModuleWarehouse\Resources\Batch\{
    ViewBatch
};
use Hanafalah\LaravelSupport\Models\BaseModel;

class Batch extends BaseModel
{
    use HasUlids;

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $list       = ['id', 'batch_no', 'expired_at'];
    protected $show       = [];

    public function getShowResource()
    {
        return ViewBatch::class;
    }

    public function getViewResource()
    {
        return ViewBatch::class;
    }
}
