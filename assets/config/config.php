<?php

use Hanafalah\ModuleWarehouse\{
    Models as ModuleWarehouseModels,
    Contracts
};

return [
    'namespace' => 'Hanafalah\\ModuleWarehouse',
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACTS HERE
        ],
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database' => [
        'models' => [
        ]
    ],
    'warehouse' => ModuleWarehouseModels\Building\Room::class
];
