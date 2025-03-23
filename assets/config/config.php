<?php

use Hanafalah\ModuleWarehouse\{
    Models as ModuleWarehouseModels,
    Contracts
};

return [
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACTS HERE
            'building'           => Contracts\Building::class,
            'room'               => Contracts\Room::class,
            'stock'              => Contracts\Stock::class,
            'batch'              => Contracts\Batch::class,
            'stock_movement'     => Contracts\StockMovement::class,
            'batch_movement'     => Contracts\BatchMovement::class,
            'model_has_room'     => Contracts\ModelHasRoom::class,
            'stock_batch'        => Contracts\StockBatch::class,
            'goods_receipt_unit' => Contracts\GoodsReceiptUnit::class
        ],
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts'
    ],
    'database' => [
        'models' => [
            'Building'         => ModuleWarehouseModels\Building\Building::class,
            'Room'             => ModuleWarehouseModels\Building\Room::class,
            'Stock'            => ModuleWarehouseModels\Stock\Stock::class,
            'MainStock'        => ModuleWarehouseModels\Stock\MainStock::class,
            'MainMovement'     => ModuleWarehouseModels\Stock\MainMovement::class,
            'Batch'            => ModuleWarehouseModels\Stock\Batch::class,
            'StockMovement'    => ModuleWarehouseModels\Stock\StockMovement::class,
            'BatchMovement'    => ModuleWarehouseModels\Stock\BatchMovement::class,
            'Storage'          => ModuleWarehouseModels\Storage\Storage::class,
            'ModelHasStorage'  => ModuleWarehouseModels\Storage\ModelHasStorage::class,
            'ModelHasRoom'     => ModuleWarehouseModels\ModelHasRoom\ModelHasRoom::class,
            'StockFunding'     => ModuleWarehouseModels\Stock\StockFunding::class,
            'StockBatch'       => ModuleWarehouseModels\Stock\StockBatch::class,
            'GoodsReceiptUnit' => ModuleWarehouseModels\Stock\GoodsReceiptUnit::class
        ]
    ],
    'warehouse' => ModuleWarehouseModels\Building\Room::class
];
