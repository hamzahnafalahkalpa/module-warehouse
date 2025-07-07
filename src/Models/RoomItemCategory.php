<?php

namespace Hanafalah\ModuleWarehouse\Models;

use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Hanafalah\ModuleWarehouse\Resources\RoomItemCategory\{
    ViewRoomItemCategory,
    ShowRoomItemCategory
};

class RoomItemCategory extends Unicode
{
    protected $table = 'unicodes';    

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewRoomItemCategory::class;
    }

    public function getShowResource(){
        return ShowRoomItemCategory::class;
    }
}
