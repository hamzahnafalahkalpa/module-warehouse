<?php

namespace Hanafalah\ModuleWarehouse\Models\Building;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasPhone;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleRegional\Concerns\HasAddress;
use Hanafalah\ModuleWarehouse\Resources\Building\ViewBuilding;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Building extends BaseModel
{
    use HasUlids, SoftDeletes, HasAddress, HasPhone, HasProps;

    public $incrmeenting = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list = ['id', 'name', 'flag'];

    protected $casts = [
        'name' => 'string'
    ];

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->flagIn('Building');
        });
        static::creating(function($query){
            $query->flag = 'Building';
        });
    }

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
