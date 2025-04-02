<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\ModelHasRoom as ContractModelHasRoom;

class ModelHasRoom extends PackageManagement implements ContractModelHasRoom
{
    protected array  $__guard   = ['room_id', 'reference_id'];
    protected array  $__add     = ['room_id', 'reference_id', "reference_type"];
    protected string $__entity = 'ModelHasRoom';

    public function modelHasRoom(mixed $conditionals = null): Builder
    {
        $this->booting();
        return $this->ModelHasRoomModel()->withParameters()->conditionals($conditionals);
    }
}
