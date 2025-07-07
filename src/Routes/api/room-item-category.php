<?php

use Hanafalah\ModuleWarehouse\Controllers\API\RoomItemCategory\RoomItemCategoryController;
use Illuminate\Support\Facades\Route;

Route::apiResource('room-item-category', RoomItemCategoryController::class)
    ->parameters(['room-item-category' => 'id']);