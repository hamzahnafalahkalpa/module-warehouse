<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

interface Room extends DataManagement
{
    public function addOrChange(?array $attributes = []): self;
    public function prepareShowRoom(?Model $model = null): Model;
    public function showRoom(?Model $model = null): array;
    public function prepareViewRoomList(): Collection;
    public function viewRoomList(): array;
    public function prepareStoreRoom(mixed $attributes = null): Model;
    public function storeRoom(): array;
    public function getRoom(): ?Model;
    public function invisibleRoom(mixed $conditionals = null): Builder;
    public function prepareDeleteRoom(?array $attributes = null): bool;
    public function deleteRoom(): bool;
    public function room(mixed $conditionals = null): Builder;
}
