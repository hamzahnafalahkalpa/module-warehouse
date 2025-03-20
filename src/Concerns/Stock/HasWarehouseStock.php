<?php

namespace Zahzah\ModuleWarehouse\Concerns\Stock;

trait HasWarehouseStock{
    public function stock(){return $this->morphOneModel('Stock','warehouse');}
    public function stocks(){return $this->morphManyModel('Stock','warehouse');}
}