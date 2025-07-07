<?php

namespace Hanafalah\ModuleWarehouse\Models;

use Hanafalah\LaravelHasProps\Concerns\HasCurrent;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ModelHasWarehouse extends BaseModel
{
    use HasUlids, HasProps, HasCurrent;

    public $current_conditions = ['model_id', 'model_type'];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list = [
        'id',
        'warehouse_type',
        'warehouse_id',
        'model_id',
        'model_type',
        'current',
        'props'
    ];

    public function model(){return $this->morphTo();}
    public function warehouse(){return $this->morphTo();}
}
