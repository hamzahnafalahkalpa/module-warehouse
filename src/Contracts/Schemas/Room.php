<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomData;

/**
 * @see \Hanafalah\ModuleWarehouse\Schemas\Room
 * @method bool deleteRoom()
 * @method mixed getRoom()
 * @method ?Model prepareShowRoom(?Model $model = null, ?array $attributes = null)
 * @method array showRoom(?Model $model = null)
 * @method Collection prepareViewRoomList()
 * @method array viewRoomList()
 * @method LengthAwarePaginator prepareViewRoomPaginate(PaginateData $paginate_dto)
 * @method array viewRoomPaginate(?PaginateData $paginate_dto = null)
 */
interface Room extends DataManagement
{
    public function prepareStoreRoom(RoomData $room_dto): Model;
    public function storeRoom(? RoomData $room_dto = null): array;
    public function prepareDeleteRoom(?array $attributes = null): bool;
    public function room(mixed $conditionals = null): Builder;
}
