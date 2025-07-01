<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\{
    Contracts\Schemas\StockMovement as ContractsStockMovement,
};
use Hanafalah\ModuleWarehouse\Contracts\Data\StockMovementData;

class StockMovement extends PackageManagement implements ContractsStockMovement
{
    protected string $__entity = 'StockMovement';
    public static $stock_movement_model;


    protected function initiateItemStock(StockMovementData &$stock_movement_dto){
        if (!isset($stock_movement_dto->item_stock_id)) {
            if (!isset($stock_movement_dto->reference_id)) throw new \Exception('warehouse_id is required when item_stock_id is not provided');
            $warehouse = $this->{config('module-warehouse.warehouse').'Model'}()->find($stock_movement_dto->reference_id);
            if (!isset($warehouse)) throw new \Exception('warehouse does not exist');

            $card_stock = $stock_movement_dto->card_stock_model ?? $this->CardStockModel()->find($stock_movement_dto->card_stock_id);
            if (!isset($card_stock)) throw new \Exception('card_stock does not exist');

            $item_stock = $this->ItemStockModel()->firstOrCreate([
                'subject_id'     => $card_stock->item_id,
                'subject_type'   => $this->ItemModel()->getMorphClass(),
                'warehouse_id'   => $warehouse->getKey(),
                'warehouse_type' => $warehouse->getMorphClass(),
                'funding_id'     => $stock_movement_dto->props->funding_id ?? null
            ], [
                'stock'          => 0
            ]);
            $stock_movement_dto->item_stock_id = $item_stock->getKey();
        } else {
            $item_stock = $this->ItemStockModel()->find($stock_movement_dto->item_stock_id);
            if (!isset($item_stock)) throw new \Exception('item_stock does not exist');
        }
        $stock_movement_dto->reference_id    ??= $item_stock->warehouse_id;
        $stock_movement_dto->reference_type  ??= $item_stock->warehouse_type;
    }

    public function prepareStoreStockMovement(StockMovementData $stock_movement_dto): Model
    {
        $add = [
            'qty'                   => $stock_movement_dto->qty ?? 0,
            'opening_stock'         => $stock_movement_dto->opening_stock ?? 0,
            'closing_stock'         => $stock_movement_dto->closing_stock ?? 0,
        ];
        if (isset($stock_movement_dto->id)) {
            $guard = ['id' => $stock_movement_dto->id];
        } else {
            $this->initiateItemStock($stock_movement_dto);
            $guard = [
                'parent_id'             => $stock_movement_dto->parent_id,
                'reference_type'        => $stock_movement_dto->reference_type,
                'reference_id'          => $stock_movement_dto->reference_id,
                'card_stock_id'         => $stock_movement_dto->card_stock_id,
                'item_stock_id'         => $stock_movement_dto->item_stock_id,
                'goods_receipt_unit_id' => $stock_movement_dto->goods_receipt_unit_id,
                'direction'             => $stock_movement_dto->direction
            ];
        }
        $stock_movement = $this->StockMovementModel()->updateOrCreate($guard, $add);
        if (isset($stock_movement_dto->batch_movements) && count($stock_movement_dto->batch_movements) > 0) {
            $batch_movement_schema = $this->schemaContract('batch_movement');
            // foreach ($stock_movement_dto->batch_movements as $batch_movement) {
            //     $batch_movement_schema->prepareStoreBatchMovement([
            //         'id'                => $batch_movement['id'] ?? null,
            //         'stock_id'          => $stock_movement->item_stock_id,
            //         'stock_movement_id' => $stock_movement->getKey(),
            //         'batch_id'          => $batch_movement['batch_id'] ?? null,
            //         'batch_no'          => $batch_movement['batch_no'] ?? null,
            //         'expired_at'        => $batch_movement['expired_at'] ?? null,
            //         'qty'               => $batch_movement['qty'] ?? 0
            //     ]);
            // }
        }
        $this->fillingProps($stock_movement, $stock_movement_dto->props);
        $stock_movement->save();

        return static::$stock_movement_model = $stock_movement;
    }
}
