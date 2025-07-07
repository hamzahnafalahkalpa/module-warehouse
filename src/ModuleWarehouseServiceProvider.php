<?php

namespace Hanafalah\ModuleWarehouse;

use Hanafalah\LaravelSupport\Providers\BaseServiceProvider;

class ModuleWarehouseServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerMainClass(ModuleWarehouse::class)
            ->registerCommandService(Providers\CommandServiceProvider::class)
            ->registers(['*']);
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
