<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomData;

/**
 * @see \Hanafalah\ModuleWarehouse\Schemas\Room
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method bool deleteRoom()
 * @method bool prepareDeleteRoom(? array $attributes = null)
 * @method mixed getRoom()
 * @method ?Model prepareShowRoom(?Model $model = null, ?array $attributes = null)
 * @method array showRoom(?Model $model = null)
 * @method Collection prepareViewRoomList()
 * @method array viewRoomList()
 * @method LengthAwarePaginator prepareViewRoomPaginate(PaginateData $paginate_dto)
 * @method array viewRoomPaginate(?PaginateData $paginate_dto = null)
 * @method array storeRoom(?RoomData $room_dto = null)
 * @method Builder room(mixed $conditionals = null)
 */
interface Room extends DataManagement
{
    public function prepareStoreRoom(RoomData $room_dto): Model;
}
