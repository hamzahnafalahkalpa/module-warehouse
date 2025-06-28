<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Hanafalah\ModuleWarehouse\Contracts\Data\RoomItemCategoryData as DataRoomItemCategoryData;

class RoomItemCategoryData extends UnicodeData implements DataRoomItemCategoryData
{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'RoomItemCategory';
        parent::before($attributes);
    }
}