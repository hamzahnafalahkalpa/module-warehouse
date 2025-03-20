<?php

namespace Zahzah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Zahzah\LaravelSupport\Supports\PackageManagement;
use Zahzah\ModuleWarehouse\Contracts\Building as ContractBuilding;
use Zahzah\ModuleWarehouse\Resources\Building\ViewBuilding;

class Building extends PackageManagement implements ContractBuilding{
    protected array $__guard   = ['id']; 
    protected array $__add     = ['name'];
    protected string $__entity = 'Building';
    public static $building_model;

    protected array $__resources = [
        'view' => ViewBuilding::class,
        'show' => ViewBuilding::class
    ];

    protected array $__cache = [
        'index' => [
            'name'     => 'building',
            'tags'     => ['building','building-index'],
            'forever'  => true
        ]
    ];
    
    public function prepareViewBuildingList(? array $attributes = null): Collection{
        $attributes ??= request()->all();

        return static::$building_model = $this->cacheWhen(!$this->isSearch(),$this->__cache['index'],function() {
            return $this->building()->get();
        });
    }
    
    public function viewBuildingList() : array{        
        return $this->transforming($this->__resources['view'],function(){
            return $this->prepareViewBuildingList();
        });
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function prepareShowBuilding(? Model $model = null, array $attributes = null) : Model{
        $attributes ??= request()->all();
        $model ??= $this->getBuilding();

        if (!isset($model)){
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('No building id provided', 422);

            $model = $this->building()->with($this->showUsingRelation())->find($id);
        }else{
            $model->load($this->showUsingRelation());
        }

        return static::$building_model = $model;
    }

    public function showBuilding(? Model $model = null) : array{
        return $this->transforming($this->__resources['show'],function() use ($model){
            return $this->prepareShowBuilding($model);
        });
    }

    public function prepareStoreBuilding(? array $attributes = null) : Model{
        $attributes ??= request()->all();

        $building = $this->BuildingModel()->updateOrCreate([
            'id' => $attributes['id'] ?? null
        ],[
            'name' => $attributes['name']
        ]);

        $this->forgetTags('building');
        return static::$building_model = $building;
    }
    
    public function storeBuilding() : array{
        return $this->transaction(function(){
            return $this->showBuilding($this->prepareStoreBuilding());
        });
    }

    public function prepareDeleteBuilding(? array $attributes = null): bool{
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('No id provided',422);
        $this->forgetTags('building');
        return $this->BuildingModel()->destroy($attributes['id']);
    }

    public function deleteBuilding() : bool{
        return $this->transaction(function(){
            return $this->prepareDeleteBuilding();
        });
    }

    public function building(): Builder{
        $this->booting();
        return $this->BuildingModel()->withParameters()->orderBy('name','asc');
    }
}
