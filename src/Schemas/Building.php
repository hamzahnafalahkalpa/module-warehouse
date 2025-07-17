<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Building as ContractBuilding;

class Building extends Unicode implements ContractBuilding
{
    protected string $__entity = 'Building';
    public static $building_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'building',
            'tags'     => ['building', 'building-index'],
            'duration'  => 24 * 60
        ]
    ];
}
