<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\ModuleWarehouse\Models\{
    RoomHasItem
};
use Hanafalah\ModuleWarehouse\Models\Building\Room;

return new class extends Migration
{
    use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.RoomHasItem', RoomHasItem::class));
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
                $room = app(config('database.models.Room', Room::class));

                $table->ulid('id')->primary();
                $table->foreignIdFor($room::class)->nullable(false)->index()->constrained()
                      ->cascadeOnDelete()->cascadeOnUpdate();
                $table->string('item_type',50)->nullable(false);
                $table->string('item_id',36)->nullable(false);
                $table->string('flag',50)->nullable(false);
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
