<?php

namespace Hanafalah\ModuleWarehouse\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleWarehouse\Contracts\Schemas\ModelHasRoom as ContractModelHasRoom;

class ModelHasRoom extends PackageManagement implements ContractModelHasRoom
{
    protected string $__entity = 'ModelHasRoom';
}
