<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\ModuleWarehouse\Models\{
    ModelHasWarehouse
};

return new class extends Migration
{
    use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.ModelHasWarehouse', ModelHasWarehouse::class));
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
                $table->ulid('id')->primary();
                $table->string("warehouse_type", 50);
                $table->string("warehouse_id", 36);
                $table->string("model_type", 50);
                $table->string("model_id", 36);
                $table->unsignedTinyInteger("current")->default(1);
                $table->json("props");
                $table->timestamps();

                $table->unique(["warehouse_type", "warehouse_id", "model_type", "model_id"], "mhw_unique");
                $table->unique(["warehouse_type", "warehouse_id"], "mhw_warehouse");
                $table->unique(["model_type", "model_id"], "mhw_model");
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
