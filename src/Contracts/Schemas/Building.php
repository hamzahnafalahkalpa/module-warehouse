<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleWarehouse\Contracts\Data\BuildingData;
use Illuminate\Database\Eloquent\Builder;

/**
 * @see \Hanafalah\ModuleWarehouse\Schemas\Building
 * @method bool deleteBuilding()
 * @method bool prepareDeleteBuilding(? array $attributes = null)
 * @method mixed getBuilding()
 * @method ?Model prepareShowBuilding(?Model $model = null, ?array $attributes = null)
 * @method array showBuilding(?Model $model = null)
 * @method Collection prepareViewBuildingList()
 * @method array viewBuildingList()
 * @method LengthAwarePaginator prepareViewBuildingPaginate(PaginateData $paginate_dto)
 * @method Model prepareStoreBuilding(BuildingData $building_dto)
 * @method array storeBuilding(? BuildingData $building_dto = null)
 * @method array viewBuildingPaginate(?PaginateData $paginate_dto = null)
 * @method Builder building(mixed $conditionals = null)
 */
interface Building extends Unicode{}
