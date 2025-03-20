<?php

namespace Zahzah\ModuleWarehouse\Models\Storage;

use Zahzah\LaravelHasProps\Concerns\HasProps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zahzah\LaravelSupport\Models\BaseModel;

class ModelHasStorage extends BaseModel{
    use HasProps, SoftDeletes;

    protected $list = [
        'id','model_type','model_id','storage_id'
    ];

    //EIGER SECCTION
    public function modelHasStorage(){return $this->hasOneModel('ModelHasStorage');}
    public function modelHasStorages(){return $this->hasManyModel('ModelHasStorage');}
    public function storage(){return $this->belongsToModel('Storage');}
    public function stock(){return $this->morphOneModel('Stock','warehouse');}
    //END EIGER SECTION
}