<?php

namespace Hanafalah\ModuleWarehouse\Models\Storage;

use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;

class Storage extends BaseModel
{
    use SoftDeletes;

    protected $list = [
        'id',
        'name'
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
    //END EIGER SECTION
}
