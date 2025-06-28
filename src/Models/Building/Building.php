<?php

namespace Hanafalah\ModuleWarehouse\Models\Building;

use Hanafalah\LaravelSupport\Concerns\Support\HasPhone;
use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Hanafalah\ModuleRegional\Concerns\HasAddress;
use Hanafalah\ModuleWarehouse\Resources\Building\ViewBuilding;

class Building extends Unicode
{
    use HasAddress, HasPhone;

    protected $table = 'unicodes';

    public function getViewResource(){
        return ViewBuilding::class;
    }

    public function getShowResource(){
        return ViewBuilding::class;
    }

    public function room(){return $this->hasOneModel('room');}
    public function rooms(){return $this->hasManyModel('Building');}
}
