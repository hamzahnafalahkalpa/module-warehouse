<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Zahzah\ModuleWarehouse\Models\Building\Building;
use Zahzah\ModuleWarehouse\Models\Building\Room;

return new class extends Migration
{
    use Zahzah\LaravelSupport\Concerns\NowYouSeeMe;
    private $__table;

    public function __construct(){
        $this->__table = app(config('database.models.Room', Room::class));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (!$this->isTableExists()){
            Schema::create($table_name, function (Blueprint $table) {
                $building = app(config('database.models.Building',Building::class));

                $table->id();
                $table->string('name',50)->nullable(false);
                $table->foreignIdFor($building::class)
                    ->index()->constrained()->cascadeOnUpdate()
                    ->restrictOnDelete();
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
