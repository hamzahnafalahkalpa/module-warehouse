<?php

namespace Hanafalah\ModuleWarehouse\Models\Stock;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;

class MainStock extends BaseModel
{
    use HasUlids, SoftDeletes;

    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    protected $show       = [];
    protected static $stock_name = 'stock';

    protected static function booted(): void
    {
        parent::booted();
        static::created(function ($query) {
            if (isset($query->parent_id)) static::recalculatingStock($query);
        });
        static::updated(function ($query) {
            if (isset($query->parent_id)) static::recalculatingStock($query, true);
        });
    }

    private static function recalculatingStock($query, $is_update = false)
    {
        if ($query->isDirty(static::$stock_name) || $query->isDirty('parent_id')) {
            $stock_name     = static::$stock_name;
            $stock          = floatval($query->{$stock_name} ?? 0);
            $original_stock = 0;
            if ($query->isDirty(static::$stock_name)) {
                $original_stock = $query->getOriginal($stock_name);
            }
            $query->load([
                'parent' => function ($query) {
                    $query->withoutGlobalScopes();
                }
            ]);
            $parent = $query->parent;
            if (isset($parent) && (!$query->wasRecentlyCreated && method_exists($query, 'hasMainMovement') || !method_exists($query, 'hasMainMovement'))) {
                $parent->{$stock_name} += $stock - $original_stock;
                $parent->save();

                if (\method_exists($query, 'stockModel')) {
                    $query->load(['stockModel' => function ($query) {
                        $query->withoutGlobalScopes();
                    }]);
                    $stock_model = $query->stockModel;
                    if (isset($stock_model)) {
                        $stock_model->{$stock_name} += $stock - $original_stock;
                        $stock_model->save();
                    }
                }
            }
        }
    }
}
