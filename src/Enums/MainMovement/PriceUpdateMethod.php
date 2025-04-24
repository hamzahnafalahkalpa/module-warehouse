<?php

namespace Hanafalah\ModuleWarehouse\Enums\MainMovement;

enum PriceUpdateMethod : string
{
    case AVERAGE = 'AVERAGE';
    case MIN     = 'MIN';
    case MAX     = 'MAX';
}