<?php

namespace Hanafalah\ModuleWarehouse;

use Hanafalah\LaravelSupport\Providers\BaseServiceProvider;

class ModuleWarehouseServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerMainClass(ModuleWarehouse::class)
            ->registerCommandService(Providers\CommandServiceProvider::class)
            ->registers([
                '*',
                'Services' => function () {
                    $this->binds([
                        Contracts\ModuleWarehouse::class => new ModuleWarehouse,
                        Contracts\Room::class => new Schemas\Room,
                        Contracts\Building::class => new Schemas\Building,
                        Contracts\ModelHasRoom::class => new Schemas\ModelHasRoom,
                        Contracts\Stock::class => new Schemas\Stock,
                        Contracts\StockMovement::class => new Schemas\StockMovement,
                        Contracts\StockBatch::class => new Schemas\StockBatch,
                        Contracts\Batch::class => new Schemas\Batch,
                        Contracts\GoodsReceiptUnit::class => new Schemas\GoodsReceiptUnit,
                        Contracts\BatchMovement::class => new Schemas\BatchMovement,
                    ]);
                }
            ]);
    }

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    protected function dir(): string
    {
        return __DIR__ . '/';
    }

    protected function migrationPath(string $path = ''): string
    {
        return database_path($path);
    }
}
