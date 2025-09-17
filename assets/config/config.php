<?php

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
    'warehouse' => 'Room',
    'funding' => null,
    'model_has_room_types' => [
        'user' => [
            'schema' => 'ModelHasRoom'
        ]
    ]
];
