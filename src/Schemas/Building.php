<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Hanafalah\ModuleWarehouse\Contracts\Data\BuildingData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Building as ContractBuilding;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Building extends Unicode implements ContractBuilding
{
    protected string $__entity = 'Building';
    public $building_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'building',
            'tags'     => ['building', 'building-index'],
            'duration'  => 24 * 60
        ]
    ];

    public function prepareStoreBuilding(BuildingData $building_dto): Model{
        $building = parent::prepareStoreUnicode($building_dto);
        return $this->building_model = $building;
    }

    public function building(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}
