<?php

namespace Hanafalah\ModuleWarehouse\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleWarehouse\Resources\WarehouseItem\{
    ViewWarehouseItem,
    ShowWarehouseItem
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class WarehouseItem extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'warehouse_type', 'warehouse_id', 'item_type', 'item_id', 'flag', 'props'
    ];

    protected $casts = [
        'name' => 'string',
        'flag' => 'string'
    ];

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewWarehouseItem::class;
    }

    public function getShowResource(){
        return ShowWarehouseItem::class;
    }

    public function warehouse(){return $this->morphTo();}
    public function item(){return $this->morphTo();}
}
