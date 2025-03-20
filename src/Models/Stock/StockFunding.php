<?php

namespace Hanafalah\ModuleWarehouse\Models\Stock;

class StockFunding extends Stock
{
    protected $table = 'stocks';

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope('has-parent', function ($query) {
            $query->whereNotNull('parent_id')->whereNotNull('funding_id');
        });

        static::created(function ($query) {
            static::updatingParentStock($query);
        });
        static::updated(function ($query) {
            static::updatingParentStock($query);
        });
    }

    public static function updatingParentStock($query)
    {
        $method = $query->getEvent();
        $parent_stock = $query->parent;

        if ($method == 'created') {
            $parent_stock->stock += $query->stock;
        }

        if ($method == 'updated') {
            $changes = $query->getDirty();
            $parent_stock->stock -= $query->getOriginal('stock') + $changes['stock'];
        }
        $parent_stock->saveQuietly();
    }
}
