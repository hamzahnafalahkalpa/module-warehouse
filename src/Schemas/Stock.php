<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Stock as ContractStock;

class Stock extends PackageManagement implements ContractStock
{
    protected string $__entity = 'Stock';
    public $stock_model;

    public function prepareStoreStock(StockData $stock_dto): Model{
        if (isset($stock_dto->id)) {
            $guard = ['id' => $stock_dto->id];
        } else {
            $guard = [
                'subject_type'     => $stock_dto->subject_type,
                'subject_id'       => $stock_dto->subject_id,
                'warehouse_type'   => $stock_dto->warehouse_type,
                'warehouse_id'     => $stock_dto->warehouse_id,
                'procurement_type' => $stock_dto->procurement_type ?? null,
                'procurement_id'   => $stock_dto->procurement_id ?? null,
                'funding_id'       => $stock_dto->funding_id ?? null,
                'supplier_id'      => $stock_dto->supplier_id ?? null,
                'supplier_type'    => $stock_dto->supplier_type ?? null
            ];
        }

        $stock_model = $this->usingEntity()->firstOrCreate($guard, [
            'stock' => isset($stock_dto->stock_batches) && count($stock_dto->stock_batches) > 0 ? 0 : $stock_dto->stock ?? 0
        ]);
        if (isset($stock_dto->stock_batches) && count($stock_dto->stock_batches) > 0) {
            $batch_schema = $this->schemaContract('batch');
            foreach ($stock_dto->stock_batches as $batch) {
                $batch_model = $batch_schema->prepareStoreBatch($batch);

                $stock_batch = $stock_model->stockBatches()->firstOrCreate([
                    'batch_id' => $batch_model->getKey(),
                    'stock_id' => $stock_model->getKey()
                ], [
                    'stock' => $batch->stock ?? 0
                ]);
                if (!$stock_batch->wasRecentlyCreated) $stock_model->stock += $batch->stock ?? 0;
                $stock_batch->save();
            }
            $stock_model->save();
        }
        $this->fillingProps($stock_model,$stock_dto->props);
        $stock_model->save();
        return $this->stock_model = $stock_model;
    }
}
