<?php

namespace Zahzah\ModuleWarehouse\Models\Building;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zahzah\LaravelHasProps\Concerns\HasProps;
use Zahzah\LaravelSupport\Models\BaseModel;
use Zahzah\ModuleWarehouse\Concerns\Stock\HasWarehouseStock;
use Zahzah\ModuleWarehouse\Resources\Room\ShowRoom;
use Zahzah\ModuleWarehouse\Resources\Room\ViewRoom;

class Room extends BaseModel{
    use HasProps, SoftDeletes, HasWarehouseStock;

    protected $list = [
        'id','building_id','name',"props"
    ];

    protected $casts = [
        'name' => 'string'
    ];

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('visible',function($query){
            $query->isVisible();
        });
    }

    public function toShowApi(){
        return new ShowRoom($this);
    }

    public function toViewApi(){
        return new ViewRoom($this);
    }

    //SCOPE SECTION
    public function scopeInvisible($builder){
        return $builder->withoutGlobalScope('visible')->isInvisible();
    }

    public function scopeIsVisible($builder){
        return $builder->where(function($query){
            $query->whereNull($this->getTable().'.props->visibility')
                  ->orWhere(function($query){
                      $query->whereNotNull($this->getTable().'.props->visibility')
                            ->where($this->getTable().'.props->visibility',true);
                  });
        });
    }

    public function scopeIsInvisible($builder){
        return $builder->where(function($query){
            $query->whereNotNull($this->getTable().'.props->visibility')
                  ->where($this->getTable().'.props->visibility',false);
        });
    }

    //EIGER SECCTION
    public function building(){return $this->belongsToModel('Building');}
    public function modelHasService(){return $this->morphOneModel('ModelHasService',"reference");}
    public function modelHasRoom(){return $this->hasOneModel('ModelHasRoom');}
    public function modelHasRooms(){return $this->hasManyModel('ModelHasRoom');}
    public function refModelHasRoom(){return $this->morphOneModel('ModelHasRoom','reference');}
    public function refModelHasRooms(){return $this->morphManyModel('ModelHasRoom','reference');}
    //END EIGER SECTION
}