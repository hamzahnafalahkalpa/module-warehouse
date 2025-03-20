<?php

namespace Zahzah\ModuleWarehouse\Models\ModelHasRoom;

use Zahzah\LaravelHasProps\Concerns\HasCurrent;
use Zahzah\LaravelHasProps\Concerns\HasProps;
use Zahzah\LaravelSupport\Models\BaseModel;
use Zahzah\ModuleWarehouse\Models\Building\Room;

class ModelHasRoom extends BaseModel {
    use HasProps, HasCurrent;

    public $current_conditions = ['reference_id','reference_type'];
    protected $list = [
        'id','room_id','reference_id','reference_type','current','props'
    ];

    //EIGER SECCTION
    public function reference(){return $this->morphTo(__FUNCTION__,"reference_id","reference_type");}
    public function room(){return $this->morphOne(Room::class,"reference");}
    //END EIGER SECTION
}