<?php

namespace Hanafalah\ModuleWarehouse\Models\Stock;

use Hanafalah\ModuleWarehouse\Resources\StockMovement\{
    ShowStockMovement,
    ViewStockMovement
};
use Hanafalah\LaravelHasProps\Concerns\HasProps;

class StockMovement extends MainMovement
{
    use HasProps;

    protected $list       = [
        'id',
        'parent_id',
        'direction',
        'card_stock_id',
        'reference_type',
        'reference_id',
        'item_stock_id',
        'goods_receipt_unit_id',
        'qty',
        'qty_unit_id',
        'opening_stock',
        'closing_stock',
        'props'
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('parent_only', function ($query) {
            $query->whereNull('parent_id');
        });
    }

    public function toShowApi()
    {
        return new ShowStockMovement($this);
    }

    public function toViewApi()
    {
        return new ViewStockMovement($this);
    }

    //SCOPE SECTION
    public function scopeIn($builder)
    {
        return $builder->where('direction', self::IN);
    }
    public function scopeOut($builder)
    {
        return $builder->where('direction', self::OUT);
    }
    public function scopeHasWarehouse($builder, $warehouse_id)
    {
        $warehouse = app(config('module-item.warehouse'));
        if (!isset($warehouse)) throw new \Exception('No warehouse model provided', 422);
        $warehouse = $warehouse->findOrFail($warehouse_id);

        return $builder->where('reference_id', $warehouse_id)->where('reference_type', $warehouse->getMorphClass());
    }
    //END SCOPE SECTION

    public function cardStock()
    {
        return $this->belongsToModel('CardStock');
    }
    public function reference()
    {
        return $this->morphTo();
    }
    public function batchMovement()
    {
        return $this->hasOneModel('BatchMovement');
    }
    public function batchMovements()
    {
        return $this->hasManyModel('BatchMovement');
    }
    public function itemStock()
    {
        return $this->belongsToModel('ItemStock');
    }
    public function unit()
    {
        return $this->belongsToModel('ItemStuff');
    }
    public function goodsReceiptUnit()
    {
        return $this->belongsToModel('GoodsReceiptUnit');
    }
    public function childs()
    {
        return $this->hasManyModel('StockMovement', 'parent_id')
            ->withoutGlobalScope('parent_only')->whereNotNull('parent_id');
    }
    public function child()
    {
        return $this->hasOneModel('StockMovement', 'parent_id')
            ->withoutGlobalScope('parent_only')->whereNotNull('parent_id');
    }
}
