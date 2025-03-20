<?php

namespace Zahzah\ModuleWarehouse\Commands;

class InstallMakeCommand extends EnvironmentCommand{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module-warehouse:install';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command ini digunakan untuk installing awal warehouse module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $provider = 'Zahzah\ModuleWarehouse\ModuleWarehouseServiceProvider';

        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag'      => 'migrations'
        ]);
        $this->info('✔️  Created migrations');

        $migrations = $this->setMigrationBasePath(database_path('migrations'))->canMigrate();
        $this->callSilent('migrate', [
            '--path' => $migrations
        ]);
        $this->info('✔️  Module Workspace tables migrated');

        $this->comment('zahzah/module-warehouse installed successfully.');
    }
}