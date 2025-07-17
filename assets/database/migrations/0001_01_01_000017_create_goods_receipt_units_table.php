<?php

use Hanafalah\ModuleItem\Models\CardStock;
use Hanafalah\ModuleItem\Models\ItemStuff;
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
        $this->__table = app(config('database.models.GoodsReceiptUnit', GoodsReceiptUnit::class));
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
                $item_stuff = app(config('database.models.ItemStuff', ItemStuff::class));

                $table->ulid('id')->primary();
                $table->foreignIdFor($card_stock::class)
                    ->index()->constrained()
                    ->cascadeOnUpdate()->restrictOnDelete();

                $table->foreignIdFor($item_stuff::class, 'unit_id')
                    ->index()->constrained($item_stuff->getTable(), 'id', 'gru_is')
                    ->cascadeOnUpdate()->restrictOnDelete();

                $table->string('unit_name', 200)->nullable(false);
                $table->unsignedBigInteger('unit_qty')->default(1)->nullable(false);
                $table->json('props')->nullable();

                $table->timestamps();
                $table->softDeletes();
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
