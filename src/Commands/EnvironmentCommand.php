<?php

namespace Hanafalah\ModuleWarehouse\Commands;

use Hanafalah\LaravelSupport\Concerns\ServiceProvider\HasMigrationConfiguration;

class EnvironmentCommand extends \Hanafalah\LaravelSupport\Commands\BaseCommand
{
    use HasMigrationConfiguration;

    protected function dir(): string
    {
        return __DIR__ . '/../';
    }
}
