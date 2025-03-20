<?php

namespace Zahzah\ModuleWarehouse\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Zahzah\LaravelSupport\Contracts\DataManagement;

interface Building extends DataManagement{
    public function prepareViewBuildingList(? array $attributes = null): Collection;
    public function viewBuildingList() : array;        
    public function showUsingRelation(): array;
    public function prepareShowBuilding(? Model $model = null, array $attributes = null) : Model;
    public function showBuilding(? Model $model = null) : array;
    public function prepareStoreBuilding(? array $attributes = null) : Model;
    public function storeBuilding() : array;
    public function prepareDeleteBuilding(? array $attributes = null): bool;
    public function deleteBuilding() : bool;
    
}