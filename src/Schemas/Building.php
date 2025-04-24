<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\BuildingData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\Building as ContractBuilding;

class Building extends PackageManagement implements ContractBuilding
{
    protected string $__entity = 'Building';
    public static $building_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'building',
            'tags'     => ['building', 'building-index'],
            'forever'  => true
        ]
    ];

    public function prepareStoreBuilding(BuildingData $building_dto): Model{
        if (isset($building_dto->id)){
            $guard = ['id' => $building_dto->id];
            $add   = ['name' => $building_dto->name];
            $create = [$guard,$add];
        }else{
            $guard = ['name' => $building_dto->name];
            $create = [$guard];
        }
        $building = $this->BuildingModel()->updateOrCreate(...$create);
        $this->forgetTags('building');
        return static::$building_model = $building;
    }

    public function storeBuilding(? BuildingData $building_dto = null): array{
        return $this->transaction(function () use ($building_dto) {
            return $this->showBuilding($this->prepareStoreBuilding($building_dto ?? $this->requestDTO(BuildingData::class)));
        });
    }

    public function building(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->BuildingModel()->conditionals($this->mergeCondition($conditionals ?? []))->withParameters()->orderBy('name', 'asc');
    }
}
