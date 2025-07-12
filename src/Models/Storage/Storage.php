<?php

namespace Hanafalah\ModuleWarehouse\Models\Storage;

use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Storage extends BaseModel
{
    use HasUlids, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
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
