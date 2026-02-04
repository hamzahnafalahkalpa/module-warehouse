<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomItemCategoryData;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\RoomItemCategory as ContractsRoomItemCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RoomItemCategory extends Unicode implements ContractsRoomItemCategory
{
    protected string $__entity = 'RoomItemCategory';
    public $room_item_category_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'room_item_category',
            'tags'     => ['room_item_category', 'room_item_category-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreRoomItemCategory(RoomItemCategoryData $room_item_category_dto): Model{
        $room_item_category = parent::prepareStoreUnicode($room_item_category_dto);
        return $this->room_item_category_model = $room_item_category;
    }

    public function roomItemCategory(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}