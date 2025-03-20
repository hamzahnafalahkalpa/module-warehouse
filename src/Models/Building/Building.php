<?php

namespace Zahzah\ModuleWarehouse\Models\Building;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zahzah\LaravelSupport\Models\BaseModel;
use Zahzah\ModuleWarehouse\Resources\Building\ViewBuilding;

class Building extends BaseModel{
    use SoftDeletes;

    protected $list = ['id','name'];

    protected $casts = [
        'name' => 'string'
    ];

    public function toViewApi(){
        return new ViewBuilding($this);
    }

    public function toShowApi(){
        return new ViewBuilding($this);
    }

    public function room(){return $this->hasOneModel('room');}
    public function rooms(){return $this->hasManyModel('Building');}
}