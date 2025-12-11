<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\ModuleWarehouse\Models\Stock\Batch;
use Hanafalah\ModuleWarehouse\Models\Stock\BatchMovement;
use Hanafalah\ModuleWarehouse\Models\Stock\StockBatch;
use Hanafalah\ModuleWarehouse\Models\Stock\StockMovement;

return new class extends Migration
{
    use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.BatchMovement', BatchMovement::class));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (!$this->isTableExists()) {
            Schema::create($table_name, function (Blueprint $table) {
                $stock_movement = app(config('database.models.StockMovement', StockMovement::class));
                $batch = app(config('database.models.Batch', Batch::class));
                $stock_batch = app(config('database.models.StockBatch', StockBatch::class));

                $table->ulid('id')->primary();
                $table->foreignIdFor($stock_movement::class)->nullable(false)
                    ->index()->constrained()->cascadeOnDelete()->cascadeOnUpdate();

                $table->foreignIdFor($batch::class)->nullable(false)
                    ->index()->constrained()->cascadeOnDelete()->cascadeOnUpdate();

                $table->foreignIdFor($stock_batch::class)->nullable(false)
                    ->index()->constrained()->restrictOnDelete()->cascadeOnUpdate();

                $table->decimal('qty', 14, 6)->default(0)->nullable(false);
                $table->decimal('opening_stock', 14, 6)->default(0)->nullable(true);
                $table->decimal('closing_stock', 14, 6)->default(0)->nullable(true);
                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table($table_name, function (Blueprint $table) use ($table_name) {
                $table->foreignIdFor($this->__table, 'parent_id')
                    ->nullable()->after($this->__table->getKeyName())
                    ->index()->constrained()->restrictOnDelete()->cascadeOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->__table->getTable());
    }
};
