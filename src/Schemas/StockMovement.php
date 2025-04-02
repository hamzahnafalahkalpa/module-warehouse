<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\{
    Contracts\Schemas\StockMovement as ContractsStockMovement,
    Resources\StockMovement as ResourcesStockMovement
};

class StockMovement extends PackageManagement implements ContractsStockMovement
{
    protected array $__guard   = [];
    protected array $__add     = [];
    protected string $__entity = 'StockMovement';

    public static $stock_movement_model;

    protected array $__resources = [
        'view' => ResourcesStockMovement\ViewStockMovement::class,
        'show' => ResourcesStockMovement\ShowStockMovement::class
    ];

    public function getStockMovement(): ?Model
    {
        return static::$stock_movement_model;
    }

    public function prepareStoreStockMovement(?array $attributes = null): Model
    {
        $attributes ??= request()->all();
        if (isset($attributes['id'])) {
            $guard = ['id' => $attributes['id']];
        } else {
            if (!isset($attributes['item_stock_id'])) {
                if (!isset($attributes['warehouse_id'])) throw new \Exception('warehouse_id is required when item_stock_id is not provided');
                $warehouse = app(config('module-warehouse.warehouse'))->find($attributes['warehouse_id']);
                if (!isset($warehouse)) throw new \Exception('warehouse does not exist');

                $card_stock = $this->CardStockModel()->find($attributes['card_stock_id']);
                if (!isset($card_stock)) throw new \Exception('card_stock does not exist');

                $item_stock = $this->ItemStockModel()->firstOrCreate([
                    'subject_id'     => $card_stock->item_id,
                    'subject_type'   => $this->ItemModel()->getMorphClass(),
                    'warehouse_id'   => $warehouse->getKey(),
                    'warehouse_type' => $warehouse->getMorphClass(),
                    'funding_id'     => $attributes['funding_id'] ?? null
                ], [
                    'stock'          => 0
                ]);
                $attributes['item_stock_id'] = $item_stock->getKey();
            } else {
                $item_stock = $this->ItemStockModel()->find($attributes['item_stock_id']);
                if (!isset($item_stock)) throw new \Exception('item_stock does not exist');
            }
            $attributes['reference_id']    ??= $item_stock->warehouse_id;
            $attributes['reference_type']  ??= $item_stock->warehouse_type;

            $guard = [
                'parent_id'             => $attributes['parent_id'] ?? null,
                'reference_type'        => $attributes['reference_type'],
                'reference_id'          => $attributes['reference_id'],
                'card_stock_id'         => $attributes['card_stock_id'],
                'item_stock_id'         => $attributes['item_stock_id'],
                'goods_receipt_unit_id' => $attributes['goods_receipt_unit_id'] ?? null,
                'direction'             => $attributes['direction']
            ];
        }

        $stock_movement = $this->StockMovementModel()->updateOrCreate($guard, [
            'qty'                   => $attributes['qty'] ?? 0,
            'opening_stock'         => $attributes['opening_stock'] ?? 0,
            'closing_stock'         => $attributes['closing_stock'] ?? 0,
        ]);

        if (isset($attributes['margin'])) {
            $stock_movement->margin = intval($attributes['margin']);
        }

        if (isset($attributes['batch_movements']) && count($attributes['batch_movements']) > 0) {
            $batch_movement_schema = $this->schemaContract('batch_movement');
            foreach ($attributes['batch_movements'] as $batch_movement) {
                $batch_movement_schema->prepareStoreBatchMovement([
                    'id'                => $batch_movement['id'] ?? null,
                    'stock_id'          => $stock_movement->item_stock_id,
                    'stock_movement_id' => $stock_movement->getKey(),
                    'batch_id'          => $batch_movement['batch_id'] ?? null,
                    'batch_no'          => $batch_movement['batch_no'] ?? null,
                    'expired_at'        => $batch_movement['expired_at'] ?? null,
                    'qty'               => $batch_movement['qty'] ?? 0
                ]);
            }
        }
        $stock_movement->save();

        return static::$stock_movement_model = $stock_movement;
    }
}
