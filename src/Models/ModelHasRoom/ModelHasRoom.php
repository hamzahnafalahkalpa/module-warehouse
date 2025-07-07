<?php

namespace Hanafalah\ModuleWarehouse\Models\ModelHasRoom;

use Hanafalah\ModuleWarehouse\Models\Building\Room;
use Hanafalah\ModuleWarehouse\Models\ModelHasWarehouse;

class ModelHasRoom extends ModelHasWarehouse
{
    protected $table = 'model_has_warehouses';

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('warehouse_type',function($query){
            $query->where('warehouse_type','Room');
        });
        static::creating(function($query){
            $query->warehouse_type ??= 'Room';
        });
    }

    public function room()
    {
        return $this->morphOne(Room::class, "model");
    }
    //END EIGER SECTION
}
