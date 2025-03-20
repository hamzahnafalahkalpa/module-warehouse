<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Room as ContractRoom;
use Hanafalah\ModuleWarehouse\Resources\Room as ResourcesRoom;

class Room extends PackageManagement implements ContractRoom
{
    protected array $__guard   = ['id'];
    protected array $__add     = ['building_id', 'name'];
    protected string $__entity = 'Room';
    public static $room_model;

    protected array $__resources = [
        'view' => ResourcesRoom\ViewRoom::class,
        'show' => ResourcesRoom\ShowRoom::class
    ];

    protected array $__cache = [
        'index' => [
            'name'     => 'room',
            'tags'     => ['room', 'room-index'],
            'forever'  => true
        ],
        'show' => [
            'name'     => 'room',
            'tags'     => ['room', 'room-index'],
            'duration' => 60 * 12
        ]
    ];

    public function addOrChange(?array $attributes = []): self
    {
        $this->updateOrCreate($attributes);
        return $this;
    }

    protected function showUsingRelation()
    {
        return ['building'];
    }

    public function prepareShowRoom(?Model $model = null): Model
    {
        $model ??= $this->getRoom();

        if (!isset($model)) {
            $id = request()->id;
            if (!request()->has('id')) throw new \Exception('No id provided', 422);

            $model = $this->RoomModel()->with($this->showUsingRelation())->find($id);
        } else {
            $model->load($this->showUsingRelation());
        }
        return $model;
    }

    public function showRoom(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], function () use ($model) {
            return $this->prepareShowRoom($model);
        });
    }

    public function prepareStoreRoom(mixed $attributes = null): Model
    {
        $attributes ??= request()->all();

        $building = $this->BuildingModel()->findOrFail($attributes['building_id']);

        $room = $this->RoomModel()->updateOrCreate([
            'id'          => $attributes['id'] ?? null,
        ], [
            'building_id' => $building->getKey(),
            'name'        => $attributes['name']
        ]);
        $room->floor       = $attributes['floor'];
        $room->phone       = $attributes['phone'];
        $room->save();

        static::$room_model = $room;

        $this->forgetTags('room');
        return $room;
    }

    public function storeRoom(): array
    {
        $this->booting();
        return $this->transaction(function () {
            return $this->showRoom($this->prepareStoreRoom());
        });
    }

    public function prepareViewRoomList(): Collection
    {
        return $this->cacheWhen(!$this->isSearch(), $this->__cache['index'], function () {
            return $this->room()->orderBy('name', 'asc')->get();
        });
    }

    public function viewRoomList(): array
    {
        return $this->transforming($this->__resources['view'], function () {
            return $this->prepareViewRoomList();
        });
    }

    public function getRoom(): ?Model
    {
        return static::$room_model;
    }

    public function invisibleRoom(mixed $conditionals = null): Builder
    {
        return $this->room(fn($q) => $q->invisible())->conditionals($conditionals);
    }

    public function room(mixed $conditionals = null): Builder
    {
        return $this->RoomModel()->conditionals($conditionals)->withParameters();
    }

    public function prepareDeleteRoom(?array $attributes = null): bool
    {
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('No id provided', 422);
        $room = $this->RoomModel()->findOrFail($attributes['id']);
        $room->modelHasRoom()->delete();
        return $room->delete();
    }

    public function deleteRoom(): bool
    {
        return $this->transaction(function () {
            return $this->prepareDeleteRoom();
        });
    }
}
