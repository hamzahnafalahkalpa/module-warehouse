<?php

namespace Hanafalah\ModuleWarehouse\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleWarehouse\Contracts\Data\StockBatchData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleWarehouse\Schemas\StockBatch
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method bool deleteStockBatch()
 * @method bool prepareDeleteStockBatch(? array $attributes = null)
 * @method mixed getStockBatch()
 * @method ?Model prepareShowStockBatch(?Model $model = null, ?array $attributes = null)
 * @method array showStockBatch(?Model $model = null)
 * @method Collection prepareViewStockBatchList()
 * @method array viewStockBatchList()
 * @method LengthAwarePaginator prepareViewStockBatchPaginate(PaginateData $paginate_dto)
 * @method array viewStockBatchPaginate(?PaginateData $paginate_dto = null)
 * @method array storeStockBatch(?StockBatchData $stock_batch_dto = null)
 */
interface StockBatch extends DataManagement {
    public function prepareStoreStockBatch(StockBatchData $stock_batch_dto): Model;
}
