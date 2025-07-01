<?php

use Hanafalah\ModuleItem\Models\CardStock;
use Hanafalah\ModuleItem\Models\ItemStock;
use Hanafalah\ModuleItem\Models\ItemStuff;
use Hanafalah\ModuleWarehouse\Models\Stock\StockMovement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\ModuleWarehouse\Models\Stock\GoodsReceiptUnit;

return new class extends Migration
{
    use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.StockMovement', StockMovement::class));
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
                $card_stock = app(config('database.models.CardStock', CardStock::class));
                $item_stock = app(config('database.models.ItemStock', ItemStock::class));
                $item_stuff = app(config('database.models.ItemStuff', ItemStuff::class));

                $goods = app(config('database.models.GoodsReceiptUnit', GoodsReceiptUnit::class));

                $table->ulid('id')->primary();
                $table->foreignIdFor($card_stock::class)->nullable(false)
                    ->index()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
                $table->string('reference_type', 50);
                $table->string('reference_id', 36);
                $table->foreignIdFor($item_stock::class)->nullable(true)
                    ->index()->constrained()->restrictOnDelete()->cascadeOnUpdate();

                $table->foreignIdFor($goods::class)->nullable(true)
                    ->index()->constrained($goods->getTable(), $goods->getKeyName(), 'gds_stck')->restrictOnDelete()->cascadeOnUpdate();

                $table->decimal('qty', 14, 6)->default(0)->nullable(false);

                $table->foreignIdFor($item_stuff::class, 'qty_unit_id')->nullable(true)
                    ->index()->constrained($item_stuff->getTable(), $item_stock->getKeyName(), 'idx_stuff_unit')
                    ->restrictOnDelete()->cascadeOnUpdate();

                $table->decimal('opening_stock', 14, 6)->default(0)->nullable(true);
                $table->decimal('closing_stock', 14, 6)->default(0)->nullable(true);
                $table->string('direction',50)->nullable(false);

                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index([$card_stock->getForeignKey()], "sm_cs");
                $table->index(["reference_id", "reference_type"], "sm_ref");
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
