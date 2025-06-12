<?php

namespace Hanafalah\ModuleWarehouse\Models\Building;

use Hanafalah\LaravelSupport\Concerns\Support\HasPhone;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleRegional\Concerns\HasAddress;
use Hanafalah\ModuleWarehouse\Resources\Building\ViewBuilding;

class Building extends BaseModel
{
    use SoftDeletes, HasAddress, HasPhone;

    protected $list = ['id', 'name'];

    protected $casts = [
        'name' => 'string'
    ];

    public function viewUsingRelation(): array{
        return [];
    }
    
    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewBuilding::class;
    }

    public function getShowResource(){
        return ViewBuilding::class;
    }

    public function room(){return $this->hasOneModel('room');}
    public function rooms(){return $this->hasManyModel('Building');}
}
