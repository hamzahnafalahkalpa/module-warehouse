<?php

namespace Hanafalah\ModuleWarehouse\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Hanafalah\ModuleWarehouse\Contracts\Data\BuildingData as DataBuildingData;

class BuildingData extends UnicodeData implements DataBuildingData{
    public static function before(array &$attributes){
        $attributes['flag'] = 'Building';
        parent::before($attributes);
    }
}