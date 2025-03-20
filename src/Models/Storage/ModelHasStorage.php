<?php

namespace Hanafalah\ModuleWarehouse\Models\Storage;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;

class ModelHasStorage extends BaseModel
{
    use HasProps, SoftDeletes;

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
