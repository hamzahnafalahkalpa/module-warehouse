<?php

namespace Hanafalah\ModuleWarehouse\Enums\MainMovement;

enum Direction : string
{
    case IN      = 'IN';
    case OUT     = 'OUT';
    case OPNAME  = 'OPNAME';
    case REQUEST = 'REQUEST';
    case OTHER   = 'OTHER';
}