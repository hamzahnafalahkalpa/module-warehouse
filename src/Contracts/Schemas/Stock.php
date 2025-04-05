<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface Stock extends DataManagement {
    public function getStock(): ?Model;
    public function prepareShowStock(?Model $model = null, ? array $attributes = null): Model;
    public function showStock(?Model $model = null): array;
    public function prepareStoreStock(StockData $stock_dto): Model;
    public function storeStock(): array;
    public function prepareViewStockList(?array $attributes = null, mixed $conditionals = null): Collection;
    public function viewStock(): array;
}
