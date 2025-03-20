<?php

namespace Hanafalah\ModuleWarehouse\Concerns\Stock;

trait HasStock
{
    public function stock()
    {
        return $this->morphOneModel('Stock', 'subject');
    }
    public function stocks()
    {
        return $this->morphManyModel('Stock', 'subject');
    }
}
