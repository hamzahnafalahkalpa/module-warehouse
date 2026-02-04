<?php

namespace Hanafalah\ModuleWarehouse\Models\Stock;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\ModuleWarehouse\Resources\Stock\ShowStock;
use Hanafalah\ModuleWarehouse\Resources\Stock\ViewStock;

class Stock extends MainStock
{
    use HasProps;

    protected $list = [
        'id',
        'parent_id',
        'funding_id',
        'supplier_type',
        'supplier_id',
        'procurement_type',
        'procurement_id',
        'subject_type',
        'subject_id',
        'warehouse_type',
        'warehouse_id',
        'stock'
    ];

    protected $casts = [
        'funding_id'       => 'string',
        'supplier_id'      => 'string',
        'procurement_id'   => 'string',
        'subject_id'       => 'string',
        'warehouse_type'   => 'string',
        'warehouse_id'     => 'string',
        'warehouse_name'   => 'string',
        'supplier_name'    => 'string',
        'procurement_name' => 'string',
        'subject_name'     => 'string',
        'funding_name'     => 'string',
        'stock'            => 'float',
    ]; 

    public function getPropsQuery(): array{
        return [
            'warehouse_name'   => 'props->prop_warehouse->name',
            'supplier_name'    => 'props->prop_supplier->name',
            'procurement_name' => 'props->prop_procurement->name',
            'subject_name'     => 'props->prop_subject->name',
            'funding_name'     => 'props->prop_funding->name'
        ];
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            //CHECK AND CREATE PARENT STOCK IF STOCK HAS FUNDING AND PARENT STOCK DOESNT EXIST
            if (isset($query->funding_id) && !isset($query->parent_id)) {
                $stock_model  = new static();
                $parent_model = $stock_model->firstOrCreate([
                    'subject_type'   => $query->subject_type,
                    'subject_id'     => (string) $query->subject_id,
                    'warehouse_type' => $query->warehouse_type,
                    'warehouse_id'   => (string) $query->warehouse_id
                ], [
                    'stock' => 0
                ]);
                $query->parent_id = $parent_model->getKey();
            }
            static::initPropsAttribute($query);
        });
        static::updating(function ($query) {
            static::initPropsAttribute($query);
        });
    }

    private static function initPropsAttribute(&$query){
        $new = new static();
        if (isset($query->funding_id) ){
            $original = $query->getOriginal('funding_id');
            if ($query->funding_id !== $original){
                $query->props_funding = $new->FundingModel()
                                              ->findOrFail($query->funding_id)->toViewApi()->only(['id','name']);
            }
        }
        if (isset($query->supplier_id)){
            $original = $query->getOriginal('supplier_id');
            if ($query->supplier_id !== $original){
                $query->props_supplier = $new->{$query->supplier_type.'Model'}()
                                              ->findOrFail($query->supplier_id)->toViewApi()->only(['id','name']);
            }
        }
        if (isset($query->procurement_id)){
            $original = $query->getOriginal('procurement_id');
            if ($query->procurement_id !== $original){
                $query->props_procurement = $new->{$query->procurement_type.'Model'}()
                                              ->findOrFail($query->procurement_id)->toViewApi()->only(['id','name']);
            }
        }
        if (isset($query->warehouse_id)){
            $original = $query->getOriginal('warehouse_id');
            if ($query->warehouse_id !== $original){
                $query->props_warehouse = $new->{$query->warehouse_type.'Model'}()
                                              ->findOrFail($query->warehouse_id)->toViewApi()->only(['id','name']);
            }
        }
    }

    public function getViewResource(){
        return ViewStock::class;
    }

    public function getShowResource(){
        return ShowStock::class;
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    //EIGER SECTION
    public function subject(){return $this->morphTo('subject');}
    public function warehouse(){return $this->morphTo('warehouse');}
    public function stockBatch(){return $this->hasOneModel('StockBatch', 'stock_id');}
    public function stockBatches(){return $this->hasManyModel('StockBatch', 'stock_id');}
    public function funding(){return $this->belongsToModel('Funding');}
    public function supplier(){return $this->morphTo();}
    public function procurement(){return $this->morphTo();}
    public function batches(){
        return $this->belongsToManyModel(
            'Batch',
            'StockBatch',
            'stock_id',
            'batch_id'
        );
    }
}
