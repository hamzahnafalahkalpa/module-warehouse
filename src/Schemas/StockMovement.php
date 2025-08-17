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
    public $stock_movement_model;

    public function prepareStoreStockMovement(StockMovementData $stock_movement_dto): Model{
        $add = [
            'qty'                   => $stock_movement_dto->qty ?? 0,
            'opening_stock'         => $stock_movement_dto->opening_stock ?? 0,
            'closing_stock'         => $stock_movement_dto->closing_stock ?? 0,
            'item_stock_id'         => $stock_movement_dto->item_stock_id
        ];
        if (isset($stock_movement_dto->id)) {
            $guard = ['id' => $stock_movement_dto->id];
        } else {
            if (isset($stock_movement_dto->item_stock)) {
                $item_stock = $this->schemaContract('item_stock')->prepareStoreItemStock($stock_movement_dto->item_stock);
                $stock_movement_dto->item_stock_id = $item_stock->getKey();
            }
            $guard = [
                'parent_id'             => $stock_movement_dto->parent_id,
                'reference_type'        => $stock_movement_dto->reference_type,
                'reference_id'          => $stock_movement_dto->reference_id,
                'card_stock_id'         => $stock_movement_dto->card_stock_id,
                'goods_receipt_unit_id' => $stock_movement_dto->goods_receipt_unit_id,
                'direction'             => $stock_movement_dto->direction
            ];
        }
        $stock_movement = $this->usingEntity()->updateOrCreate($guard, $add);
        if (isset($stock_movement_dto->batch_movements) && count($stock_movement_dto->batch_movements) > 0) {
            $batch_movement_schema = $this->schemaContract('batch_movement');
            foreach ($stock_movement_dto->batch_movements as &$batch_movement) {
                $batch_movement->stock_movement_id = $stock_movement->getKey();
                if (isset($batch_movement->stock_batch)){
                    $stock_batch = &$batch_movement->stock_batch;
                    $stock_batch->stock_id = $stock_movement_dto->item_stock_id;
                }
                $batch_movement_schema->prepareStoreBatchMovement($batch_movement);
            }
        }
        if (isset($stock_movement_dto->reference_type)){
            $reference = $this->{$stock_movement_dto->reference_type.'Model'}();
            if (isset($stock_movement_dto->reference_id)) $reference = $reference->findOrFail($stock_movement_dto->reference_id);
            $props['prop_reference'] = $reference->toViewApi()->resolve();
        }

        $this->fillingProps($stock_movement, $stock_movement_dto->props);
        $stock_movement->save();
        return $this->stock_movement_model = $stock_movement;
    }
}
