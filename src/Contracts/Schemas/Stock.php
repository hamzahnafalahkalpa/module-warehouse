<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleWarehouse\Schemas\Stock
 * @method bool deleteStock()
 * @method bool prepareDeleteStock(? array $attributes = null)
 * @method mixed getStock()
 * @method ?Model prepareShowStock(?Model $model = null, ?array $attributes = null)
 * @method array showStock(?Model $model = null)
 * @method Collection prepareViewStockList()
 * @method array viewStockList()
 * @method LengthAwarePaginator prepareViewStockPaginate(PaginateData $paginate_dto)
 * @method Model prepareStoreStock(StockData $stock_dto)
 * @method array storeStock(? StockData $stock_dto = null)
 * @method array viewStockPaginate(?PaginateData $paginate_dto = null)
 * @method Builder stock(mixed $conditionals = null)
 */
interface Stock extends DataManagement {
    public function prepareStoreStock(StockData $stock_dto): Model;
}
