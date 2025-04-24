<?php

namespace Hanafalah\ModuleWarehouse\Models\Stock;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Hanafalah\ModuleWarehouse\Resources\GoodsReceiptUnit\{
    ShowGoodsReceiptUnit,
    ViewGoodsReceiptUnit
};
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;

class GoodsReceiptUnit extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $list       = ['id', 'card_stock_id', 'unit_id', 'unit_name', 'unit_qty', 'props'];
    protected $show       = [];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->unit_qty)) $query->unit_qty = 1;
        });
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getShowResource(){
        return ShowGoodsReceiptUnit::class;
    }

    public function getViewResource(){
        return ViewGoodsReceiptUnit::class;
    }
    public function cardStock(){return $this->belongsToModel('CardStock');}
    public function unit(){return $this->belongsToModel('ItemStuff');}
    public function stockMovement(){return $this->hasOneModel('StockMovement');}
}
