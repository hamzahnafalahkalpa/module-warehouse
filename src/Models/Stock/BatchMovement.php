<?php

namespace Hanafalah\ModuleWarehouse\Models\Stock;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\ModuleWarehouse\Resources\BatchMovement\{
    ShowBatchMovement,
    ViewBatchMovement
};

class BatchMovement extends MainMovement
{
    use HasProps;

    protected $list = [
        'id', 'parent_id', 'stock_movement_id', 'batch_id', 
        'qty', 'stock_batch_id', 'opening_stock', 'closing_stock', 'props'
    ];


    public function viewUsingRelation(): array {
        return [];
    }
    public function showUsingRelation(): array {
        return [];
    }
    public function getShowResource(){return ShowBatchMovement::class;}
    public function getViewResource(){return ViewBatchMovement::class;}
    public function batch(){return $this->belongsToModel('Batch');}
    public function stockMovement(){return $this->belongsToModel('StockMovement')->withoutGlobalScope('parent_only');}
    public function stockBatch(){return $this->belongsToModel('StockBatch');}
}
