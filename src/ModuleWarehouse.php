<?php

namespace Zahzah\ModuleWarehouse;

use Zahzah\LaravelSupport\{
    Supports\PackageManagement,
    Events as SupportEvents
};

class ModuleWarehouse extends PackageManagement implements Contracts\ModuleWarehouse{

    /**
     * The events that are fired by the workspace.
     *
     * @return array
     */
    public function events(){
        return [
            ...parent::events(),
        ];
    }
}