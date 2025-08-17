<?php

namespace Hanafalah\ModuleWarehouse\Models\Stock;

use Hanafalah\ModuleWarehouse\Resources\StockBatch\ViewStockBatch;

class StockBatch extends MainStock
{
    protected $list = [
        'id',
        'parent_id',
        'stock_id',
        'batch_id',
        'stock',
        'props'
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            $stock = app(config('database.models.Stock'))->find($query->stock_id);
            //CHECK AND CREATE PARENT STOCK BATCH IF STOCK HAS FUNDING AND PARENT STOCK BATCH DOESNT EXIST
            if (isset($stock->funding_id) && !isset($query->parent_id)) {
                $stock_batch_model = new static();
                $parent_model = $stock_batch_model->firstOrCreate([
                    'stock_id' => $stock->parent_id,
                    'batch_id' => $query->batch_id,
                    'parent_id' => null
                ], [
                    'stock' => 0
                ]);
                $query->parent_id = $parent_model->getKey();
            }
        });
    }

    public function getViewResource()
    {
        return ViewStockBatch::class;
    }

    public function getShowResource()
    {
        return ViewStockBatch::class;
    }

    //EIGER SECTION
    public function stockModel()
    {
        return $this->belongsToModel('Stock');
    }
    public function batch()
    {
        return $this->belongsToModel('Batch');
    }
}
