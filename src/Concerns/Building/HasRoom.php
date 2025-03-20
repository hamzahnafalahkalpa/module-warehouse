<?php

namespace Hanafalah\ModuleWarehouse\Concerns\Building;

trait HasRoom
{
    protected function initializeHasRoom()
    {
        $this->mergeFillable([
            $this->getRoomForeignKey()
        ]);
    }

    protected function getRoomForeignKey()
    {
        return $this->RoomModel()->getForeignKey();
    }

    public function room()
    {
        return $this->belongsToModel('Room');
    }
}
