<?php

namespace Hanafalah\ModuleWarehouse\Models\Storage;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ModelHasStorage extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list = [
        'id',
        'model_type',
        'model_id',
        'storage_id'
    ];

    //EIGER SECCTION
    public function modelHasStorage()
    {
        return $this->hasOneModel('ModelHasStorage');
    }
    public function modelHasStorages()
    {
        return $this->hasManyModel('ModelHasStorage');
    }
    public function storage()
    {
        return $this->belongsToModel('Storage');
    }
    public function stock()
    {
        return $this->morphOneModel('Stock', 'warehouse');
    }
    //END EIGER SECTION
}
