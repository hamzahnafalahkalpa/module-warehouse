<?php

namespace Hanafalah\ModuleWarehouse\Models\ModelHasRoom;

use Hanafalah\LaravelHasProps\Concerns\HasCurrent;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleWarehouse\Models\Building\Room;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ModelHasRoom extends BaseModel
{
    use HasUlids, HasProps, HasCurrent;

    public $current_conditions = ['model_id', 'model_type'];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list = [
        'id',
        'room_id',
        'model_id',
        'model_type',
        'current',
        'props'
    ];

    //EIGER SECCTION
    public function model()
    {
        return $this->morphTo(__FUNCTION__, "model_id", "model_type");
    }
    public function room()
    {
        return $this->morphOne(Room::class, "model");
    }
    //END EIGER SECTION
}
