<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomItemCategoryData;
//use Hanafalah\ModuleWarehouse\Contracts\Data\RoomItemCategoryUpdateData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleWarehouse\Schemas\RoomItemCategory
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateRoomItemCategory(?RoomItemCategoryData $room_item_category_dto = null)
 * @method Model prepareUpdateRoomItemCategory(RoomItemCategoryData $room_item_category_dto)
 * @method bool deleteRoomItemCategory()
 * @method bool prepareDeleteRoomItemCategory(? array $attributes = null)
 * @method mixed getRoomItemCategory()
 * @method ?Model prepareShowRoomItemCategory(?Model $model = null, ?array $attributes = null)
 * @method array showRoomItemCategory(?Model $model = null)
 * @method Collection prepareViewRoomItemCategoryList()
 * @method array viewRoomItemCategoryList()
 * @method LengthAwarePaginator prepareViewRoomItemCategoryPaginate(PaginateData $paginate_dto)
 * @method array viewRoomItemCategoryPaginate(?PaginateData $paginate_dto = null)
 * @method array storeRoomItemCategory(?RoomItemCategoryData $room_item_category_dto = null)
 * @method Collection prepareStoreMultipleRoomItemCategory(array $datas)
 * @method array storeMultipleRoomItemCategory(array $datas)
 */

interface RoomItemCategory extends Unicode{}