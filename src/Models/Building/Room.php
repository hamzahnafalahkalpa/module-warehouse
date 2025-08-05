<?php

namespace Hanafalah\ModuleWarehouse\Models\Building;

use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleWarehouse\Concerns\Stock\HasWarehouseStock;
use Hanafalah\ModuleWarehouse\Resources\Room\ShowRoom;
use Hanafalah\ModuleWarehouse\Resources\Room\ViewRoom;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Room extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasWarehouseStock;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primary = 'id';
    protected $list = [
        'id',
        'building_id',
        'name',
        'room_number',
        "props"
    ];

    protected $casts = [
        'name'          => 'string',
        'building_name' => 'string'
    ];

    public function getPropsQuery(): array
    {
        return [
            'building_name' => 'props->prop_building->name'
        ];
    }

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('visible', function ($query) {
            // $query->isVisible();
        });
        static::deleting(function ($query) {
            $query->modelHasRoom()->delete();
        });
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [
            'modelHasRooms', 'warehouseItems'
        ];
    }

    public function getShowResource(){return ShowRoom::class;}
    public function getViewResource(){return ViewRoom::class;}
    public function scopeInvisible($builder){return $builder->withoutGlobalScope('visible')->isInvisible();}
    public function scopeIsVisible($builder){
        return $builder->where(function ($query) {
            $query->whereNull($this->getTable() . '.props->visibility')
                ->orWhere(function ($query) {
                    $query->whereNotNull($this->getTable() . '.props->visibility')
                        ->where($this->getTable() . '.props->visibility', true);
                });
        });
    }
    public function scopeIsInvisible($builder){
        return $builder->where(function ($query) {
            $query->whereNotNull($this->getTable() . '.props->visibility')
                ->where($this->getTable() . '.props->visibility', false);
        });
    }

    //EIGER SECCTION
    public function building(){return $this->belongsToModel('Building');}
    public function modelHasService(){return $this->morphOneModel('ModelHasService', "reference");}
    public function modelHasRoom(){return $this->morphOneModel('ModelHasRoom','warehouse');}
    public function modelHasRooms(){return $this->morphManyModel('ModelHasRoom','warehouse');}
    public function warehouseItem(){return $this->morphOneModel('WarehouseItem','warehouse');}
    public function warehouseItems(){return $this->morphManyModel('WarehouseItem','warehouse');}
    public function refModelHasRoom(){return $this->morphOneModel('ModelHasRoom', 'reference');}
    public function refModelHasRooms(){return $this->morphManyModel('ModelHasRoom', 'reference');}
    public function roomHasItem(){return $this->hasOneModel('RoomHasItem');}
    public function roomHasItems(){return $this->hasManyModel('RoomHasItem');}
}
